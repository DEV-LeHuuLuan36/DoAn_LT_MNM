<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Claim;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CampusLostAndFoundTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected User $student;
    protected User $otherStudent;
    protected Category $category;
    protected Location $location;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin', 'is_locked' => false]);
        $this->student = User::where('role', 'user')->first() ?? User::factory()->create(['role' => 'user', 'is_locked' => false]);
        $this->otherStudent = User::where('role', 'user')->where('id', '!=', $this->student->id)->first()
            ?? User::factory()->create(['role' => 'user', 'is_locked' => false]);

        $this->category = Category::first() ?? Category::create(['name' => 'Điện thoại', 'slug' => 'dien-thoai']);
        $this->location = Location::first() ?? Location::create(['name' => 'Thư viện']);
    }

    /**
     * TC01: Đăng ký tài khoản sinh viên mới thành công
     */
    public function test_tc01_user_registration(): void
    {
        $uniqueEmail = 'test_student_' . uniqid() . '@huit.edu.vn';
        $response = $this->post('/register', [
            'name' => 'Sinh Viên Test',
            'email' => $uniqueEmail,
            'student_code' => '2001239999',
            'phone' => '0988888888',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $response->assertRedirect(route('items.index'));
        $this->assertDatabaseHas('users', [
            'email' => $uniqueEmail,
            'student_code' => '2001239999',
            'role' => 'user',
            'is_locked' => false,
        ]);
        $this->assertAuthenticated();
    }

    /**
     * TC02: Đăng nhập thành công, thất bại và tài khoản bị khóa
     */
    public function test_tc02_user_login_and_locked_check(): void
    {
        // 1. Đăng nhập sai mật khẩu
        $failResponse = $this->post('/login', [
            'email' => $this->student->email,
            'password' => 'wrong_password',
        ]);
        $failResponse->assertSessionHasErrors('email');
        $this->assertGuest();

        // 2. Đăng nhập thành công với sinh viên
        $successResponse = $this->post('/login', [
            'email' => $this->student->email,
            'password' => '123456',
        ]);
        $successResponse->assertRedirect(route('items.index'));
        $this->assertAuthenticatedAs($this->student);

        // Đăng xuất để test trường hợp bị khóa
        $this->post('/logout');

        // 3. Đăng nhập khi tài khoản bị khóa
        $this->student->update(['is_locked' => true]);
        $lockedResponse = $this->post('/login', [
            'email' => $this->student->email,
            'password' => '123456',
        ]);
        $lockedResponse->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->student->update(['is_locked' => false]);
    }

    /**
     * TC03: Đăng xuất tài khoản
     */
    public function test_tc03_user_logout(): void
    {
        $this->actingAs($this->student);
        $response = $this->post('/logout');
        $response->assertRedirect(route('items.index'));
        $this->assertGuest();
    }

    /**
     * TC04: Lọc và tìm kiếm bài đăng tại trang chủ
     */
    public function test_tc04_browse_and_filter_items(): void
    {
        $response = $this->get('/?type=lost&category_id=' . $this->category->id);
        $response->assertStatus(200);
        $response->assertViewIs('items.index');
        $response->assertViewHas('items');
    }

    /**
     * TC05: Xem chi tiết bài đăng và kiểm soát quyền truy cập
     */
    public function test_tc05_view_item_details(): void
    {
        $approvedItem = Item::where('status', 'approved')->first();
        if ($approvedItem) {
            $response = $this->get(route('items.show', $approvedItem));
            $response->assertStatus(200);
            $response->assertSee($approvedItem->title);
        }

        // Bài pending: khách không được xem (403)
        $pendingItem = Item::where('status', 'pending')->first();
        if ($pendingItem) {
            $this->get(route('items.show', $pendingItem))->assertStatus(403);

            // Tác giả xem được bài pending của chính mình
            $author = $pendingItem->user;
            $this->actingAs($author)->get(route('items.show', $pendingItem))->assertStatus(200);
        }
    }

    /**
     * TC06: Đăng bài mới (mặc định status là pending)
     */
    public function test_tc06_create_new_item(): void
    {
        $this->actingAs($this->student);

        $response = $this->post(route('items.store'), [
            'type' => 'lost',
            'title' => 'Tìm chìa khóa Smartkey Honda Vision màu đỏ',
            'description' => 'Đánh rơi lúc 8h sáng gần cổng số 1 đường Lê Trọng Tấn',
            'category_id' => $this->category->id,
            'location_id' => $this->location->id,
            'event_date' => Carbon::now()->toDateString(),
            'contact_info' => '0912345678',
        ]);

        $response->assertRedirect(route('profile.my-items'));
        $this->assertDatabaseHas('items', [
            'title' => 'Tìm chìa khóa Smartkey Honda Vision màu đỏ',
            'status' => 'pending',
            'user_id' => $this->student->id,
        ]);
    }

    /**
     * TC07: Đăng bình luận trao đổi
     */
    public function test_tc07_create_comment(): void
    {
        $this->actingAs($this->student);
        $item = Item::where('status', 'approved')->first();

        $response = $this->post(route('comments.store', $item), [
            'content' => 'Bạn kiểm tra thử tại phòng bảo vệ xem nhé!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $this->student->id,
            'content' => 'Bạn kiểm tra thử tại phòng bảo vệ xem nhé!',
        ]);
    }

    /**
     * TC08: Chỉnh sửa bài đăng (chỉ tác giả, sau khi sửa chuyển về pending)
     */
    public function test_tc08_edit_item_ownership_and_status_reset(): void
    {
        $item = Item::create([
            'user_id' => $this->student->id,
            'category_id' => $this->category->id,
            'location_id' => $this->location->id,
            'type' => 'found',
            'title' => 'Nhặt được thẻ ATM BIDV trước cổng trường',
            'description' => 'Thẻ BIDV mang tên Nguyen Van B',
            'event_date' => Carbon::now()->toDateString(),
            'status' => 'approved',
        ]);

        // 1. Người khác cố tình sửa -> 403 Forbidden
        $this->actingAs($this->otherStudent);
        $responseForbidden = $this->get(route('items.edit', $item));
        $responseForbidden->assertStatus(403);

        // 2. Chính chủ sửa -> thành công và trạng thái quay về pending
        $this->actingAs($this->student);
        $responseUpdate = $this->put(route('items.update', $item), [
            'type' => 'found',
            'title' => 'Nhặt được thẻ ATM BIDV trước cổng trường (ĐÃ SỬA)',
            'description' => 'Thẻ BIDV mang tên Nguyen Van B - chi tiết thêm',
            'category_id' => $this->category->id,
            'location_id' => $this->location->id,
            'event_date' => Carbon::now()->toDateString(),
        ]);

        $responseUpdate->assertRedirect(route('items.show', $item));
        $item->refresh();
        $this->assertEquals('pending', $item->status);
        $this->assertEquals('Nhặt được thẻ ATM BIDV trước cổng trường (ĐÃ SỬA)', $item->title);
    }

    /**
     * TC09: Xóa bài đăng (chỉ tác giả)
     */
    public function test_tc09_delete_item(): void
    {
        $item = Item::create([
            'user_id' => $this->student->id,
            'category_id' => $this->category->id,
            'location_id' => $this->location->id,
            'type' => 'lost',
            'title' => 'Bài viết cần xóa thử nghiệm',
            'description' => 'Mô tả bài viết cần xóa thử nghiệm',
            'event_date' => Carbon::now()->toDateString(),
            'status' => 'approved',
        ]);

        // Người khác xóa -> 403
        $this->actingAs($this->otherStudent);
        $this->delete(route('items.destroy', $item))->assertStatus(403);

        // Tác giả xóa -> thành công
        $this->actingAs($this->student);
        $this->delete(route('items.destroy', $item))->assertRedirect();
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    /**
     * TC10: Kiểm thử phân trang > 9 bài đăng
     */
    public function test_tc10_pagination_greater_than_9_items(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $itemsOnPage = $response->viewData('items');
        $this->assertLessThanOrEqual(9, $itemsOnPage->count());
        $this->assertGreaterThan(9, $itemsOnPage->total());
        $this->assertTrue($itemsOnPage->hasPages());
    }

    /**
     * TC11: Gửi yêu cầu nhận đồ (Claim) và chống trùng lặp
     */
    public function test_tc11_claim_submission_rules(): void
    {
        $item = Item::create([
            'user_id' => $this->student->id,
            'category_id' => $this->category->id,
            'location_id' => $this->location->id,
            'type' => 'found',
            'title' => 'Nhặt được ví tiền có nhiều thẻ ngân hàng',
            'description' => 'Nhặt được ở cầu thang Tòa A',
            'event_date' => Carbon::now()->toDateString(),
            'status' => 'approved',
        ]);

        // 1. Tác giả không thể tự claim đồ của chính mình (403)
        $this->actingAs($this->student);
        $this->post(route('claims.store', $item), [
            'message' => 'Đây là ví của mình, trong ví có thẻ CCCD và 500k',
        ])->assertStatus(403);

        // 2. Người khác gửi claim < 20 ký tự -> Lỗi validate
        $this->actingAs($this->otherStudent);
        $invalidResponse = $this->post(route('claims.store', $item), [
            'message' => 'Ví của tôi',
        ]);
        $invalidResponse->assertSessionHasErrors('message');

        // 3. Gửi claim hợp lệ >= 20 ký tự
        $validResponse = $this->post(route('claims.store', $item), [
            'message' => 'Ví da màu nâu hiệu Pedro, bên trong có thẻ sinh viên tên Nguyễn Văn C và 200k tiền mặt.',
        ]);
        $validResponse->assertRedirect();
        $this->assertDatabaseHas('claims', [
            'item_id' => $item->id,
            'user_id' => $this->otherStudent->id,
            'status' => 'pending',
        ]);

        // 4. Gửi tiếp claim lần 2 khi claim cũ đang pending -> Báo lỗi trùng lặp
        $duplicateResponse = $this->post(route('claims.store', $item), [
            'message' => 'Gửi lại yêu cầu: ví da Pedro màu nâu có thẻ sinh viên.',
        ]);
        $duplicateResponse->assertSessionHas('error');
    }

    /**
     * TC12: Admin xử lý Claim (Duyệt approved -> item thành returned, claim khác thành rejected)
     */
    public function test_tc12_admin_handles_claim_transaction(): void
    {
        $this->actingAs($this->admin);

        $item = Item::create([
            'user_id' => $this->student->id,
            'category_id' => $this->category->id,
            'location_id' => $this->location->id,
            'type' => 'found',
            'title' => 'Nhặt được tai nghe Sony WH-1000XM4',
            'description' => 'Tai nghe màu bạc để quên phòng B301',
            'event_date' => Carbon::now()->toDateString(),
            'status' => 'approved',
        ]);

        // Tạo 2 claim của 2 sinh viên khác nhau
        $claim1 = Claim::create([
            'item_id' => $item->id,
            'user_id' => $this->otherStudent->id,
            'message' => 'Tai nghe có dán sticker hình rùa nhỏ ở củ tai bên trái.',
            'status' => 'pending',
        ]);

        $anotherStudent = User::factory()->create(['role' => 'user', 'is_locked' => false]);
        $claim2 = Claim::create([
            'item_id' => $item->id,
            'user_id' => $anotherStudent->id,
            'message' => 'Tai nghe màu bạc mình làm rơi chiều hôm qua.',
            'status' => 'pending',
        ]);

        // Admin duyệt claim1
        $response = $this->patch(route('admin.claims.handle', $claim1), [
            'status' => 'approved',
            'admin_note' => 'Đã đối chiếu sticker và serial number chuẩn xác.',
        ]);

        $response->assertRedirect();

        // Kiểm tra item đã thành returned
        $item->refresh();
        $this->assertEquals('returned', $item->status);

        // Kiểm tra claim1 đã thành approved
        $claim1->refresh();
        $this->assertEquals('approved', $claim1->status);

        // Kiểm tra claim2 tự động bị rejected
        $claim2->refresh();
        $this->assertEquals('rejected', $claim2->status);
    }

    /**
     * TC13: Ngăn chặn xóa danh mục khi đang có bài đăng liên kết
     */
    public function test_tc13_category_delete_prevention(): void
    {
        $this->actingAs($this->admin);

        // Danh mục $this->category đang có bài đăng liên kết
        $this->assertTrue($this->category->items()->exists());

        $response = $this->delete(route('admin.categories.destroy', $this->category));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $this->category->id]);

        // Tạo danh mục mới không có bài đăng nào
        $emptyCategory = Category::create([
            'name' => 'Danh mục rỗng thử nghiệm',
            'slug' => 'danh-muc-rong-thu-nghiem',
        ]);

        $responseEmpty = $this->delete(route('admin.categories.destroy', $emptyCategory));
        $responseEmpty->assertSessionHas('success');
        $this->assertDatabaseMissing('categories', ['id' => $emptyCategory->id]);
    }

    /**
     * TC14: Quản trị người dùng (khóa/mở khóa, phân quyền, xóa)
     */
    public function test_tc14_user_management(): void
    {
        $this->actingAs($this->admin);

        $testUser = User::factory()->create([
            'name' => 'User For Admin Test',
            'email' => 'admin_test_' . uniqid() . '@huit.edu.vn',
            'role' => 'user',
            'is_locked' => false,
        ]);

        // 1. Khóa tài khoản
        $this->patch(route('admin.users.update', $testUser), ['toggle_lock' => 1]);
        $testUser->refresh();
        $this->assertTrue($testUser->is_locked);

        // 2. Mở khóa tài khoản
        $this->patch(route('admin.users.update', $testUser), ['toggle_lock' => 1]);
        $testUser->refresh();
        $this->assertFalse($testUser->is_locked);

        // 3. Nâng quyền thành admin
        $this->patch(route('admin.users.update', $testUser), ['role' => 'admin']);
        $testUser->refresh();
        $this->assertEquals('admin', $testUser->role);

        // 4. Xóa tài khoản
        $this->delete(route('admin.users.destroy', $testUser));
        $this->assertDatabaseMissing('users', ['id' => $testUser->id]);

        // 5. Admin không thể tự khóa hoặc xóa chính mình
        $this->patch(route('admin.users.update', $this->admin), ['toggle_lock' => 1])
            ->assertSessionHas('error');
        $this->delete(route('admin.users.destroy', $this->admin))
            ->assertSessionHas('error');
    }
}

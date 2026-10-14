@extends('layouts.admin')

@section('title', 'Xử Lý Yêu Cầu Nhận Đồ - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <span class="badge bg-warning text-dark text-uppercase mb-1">Quy trình xác minh sở hữu</span>
            <h1 class="h4 fw-bold text-dark mb-0">XỬ LÝ YÊU CẦU NHẬN LẠI ĐỒ THẤT LẠC</h1>
        </div>
        <div>
            <span class="small text-muted">Tổng số yêu cầu: {{ $claims->total() }}</span>
        </div>
    </div>

    <!-- Bộ lọc trạng thái claim -->
    <form action="{{ route('admin.claims.index') }}" method="GET" class="row g-2 mb-4 bg-light p-3 rounded border">
        <div class="col-md-4">
            <label for="status" class="form-label small fw-bold text-secondary text-uppercase mb-1">Trạng thái yêu cầu:</label>
            <select name="status" id="status" class="form-select form-select-sm">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>[CHỜ DUYỆT - ĐANG XỬ LÝ]</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>[ĐÃ DUYỆT - TRAO TRẢ]</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>[TỪ CHỐI]</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-1">
            <button type="submit" class="btn btn-primary btn-sm fw-bold w-100">[LỌC]</button>
            <a href="{{ route('admin.claims.index') }}" class="btn btn-outline-secondary btn-sm">[XÓA]</a>
        </div>
    </form>

    @if($claims->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-bold">Không có yêu cầu nhận đồ nào trong mục này</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr>
                        <th class="py-2">Mã</th>
                        <th class="py-2">Người gửi yêu cầu</th>
                        <th class="py-2">Bài đăng đồ vật</th>
                        <th class="py-2">Đặc điểm nhận dạng chứng minh</th>
                        <th class="py-2">Thời gian</th>
                        <th class="py-2">Trạng thái</th>
                        <th class="py-2">Ghi chú của Admin</th>
                        <th class="py-2 text-end">Thao tác xử lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($claims as $claim)
                        <tr>
                            <td>#{{ $claim->id }}</td>
                            <td>
                                <strong class="d-block">{{ $claim->user->name }}</strong>
                                <span class="text-muted" style="font-size: 0.75rem;">MSSV: {{ $claim->user->student_code ?? 'Chưa cập nhật' }}</span>
                                <div class="text-muted" style="font-size: 0.75rem;">SĐT: {{ $claim->user->phone ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <a href="{{ route('items.show', $claim->item) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                                    {{ Str::limit($claim->item->title, 35) }}
                                </a>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    Đăng bởi: {{ $claim->item->user->name }} ({{ $claim->item->status }})
                                </div>
                            </td>
                            <td>
                                <div class="p-2 bg-light rounded border text-secondary" style="max-width: 250px; white-space: pre-wrap; font-size: 0.8rem;">
                                    {{ $claim->message }}
                                </div>
                            </td>
                            <td>{{ $claim->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($claim->status === 'pending')
                                    <span class="badge bg-warning text-dark">[CHỜ DUYỆT]</span>
                                @elseif($claim->status === 'approved')
                                    <span class="badge bg-success">[ĐÃ DUYỆT - TRAO TRẢ]</span>
                                @elseif($claim->status === 'rejected')
                                    <span class="badge bg-secondary">[TỪ CHỐI]</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $claim->admin_note ?? 'Chưa có ghi chú' }}</small>
                            </td>
                            <td class="text-end">
                                @if($claim->status === 'pending')
                                    <button type="button" class="btn btn-primary btn-sm py-1 px-2 fw-bold" data-bs-toggle="modal" data-bs-target="#claimModal{{ $claim->id }}">
                                        [XỬ LÝ ĐỐI CHIẾU]
                                    </button>

                                    <!-- Modal Xử lý Claim -->
                                    <div class="modal fade text-start" id="claimModal{{ $claim->id }}" tabindex="-1" aria-labelledby="claimModalLabel{{ $claim->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.claims.handle', $claim) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title h6 fw-bold" id="claimModalLabel{{ $claim->id }}">XỬ LÝ YÊU CẦU NHẬN ĐỒ #{{ $claim->id }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body small">
                                                        <div class="mb-3">
                                                            <strong>Người yêu cầu:</strong> {{ $claim->user->name }} ({{ $claim->user->email }})<br>
                                                            <strong>MSSV:</strong> {{ $claim->user->student_code ?? 'N/A' }} | <strong>SĐT:</strong> {{ $claim->user->phone ?? 'N/A' }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>Bài đăng liên quan:</strong> {{ $claim->item->title }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Mô tả của người yêu cầu:</label>
                                                            <div class="p-2 bg-light rounded border text-muted">
                                                                {{ $claim->message }}
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="claim_status_{{ $claim->id }}" class="form-label fw-bold">Quyết định phê duyệt: <span class="text-danger">*</span></label>
                                                            <select name="status" id="claim_status_{{ $claim->id }}" class="form-select" required>
                                                                <option value="approved">[DUYỆT] Xác nhận đúng chủ sở hữu (Đổi tin thành [ĐÃ TRẢ])</option>
                                                                <option value="rejected">[TỪ CHỐI] Không trùng khớp đặc điểm nhận dạng</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="admin_note_{{ $claim->id }}" class="form-label fw-bold">Ghi chú của Admin (nếu có):</label>
                                                            <textarea name="admin_note" id="admin_note_{{ $claim->id }}" rows="3" class="form-control" placeholder="Ghi chú kết quả đối chiếu, hướng dẫn nhận đồ..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">[HỦY]</button>
                                                        <button type="submit" class="btn btn-primary btn-sm fw-bold">[LƯU KẾT QUẢ]</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted" style="font-size: 0.75rem;">[ĐÃ XONG]</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $claims->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Xử Lý Yêu Cầu Nhận Đồ - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm rounded-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <span class="badge bg-warning-subtle text-dark border border-warning-subtle text-uppercase mb-1 px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Quy trình xác minh sở hữu</span>
            <h1 class="h4 fw-bold text-dark mb-0">Xử lý yêu cầu nhận lại đồ thất lạc</h1>
        </div>
        <div>
            <span class="small text-muted">Tổng số yêu cầu: {{ $claims->total() }}</span>
        </div>
    </div>

    <!-- Bộ lọc trạng thái claim -->
    <form action="{{ route('admin.claims.index') }}" method="GET" class="row g-2 mb-4 bg-light p-3 rounded-3 border">
        <div class="col-md-4">
            <label for="status" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Trạng thái yêu cầu:</label>
            <select name="status" id="status" class="form-select form-select-sm py-2">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ duyệt – Đang xử lý</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Đã duyệt – Trao trả</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Từ chối</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-1">
            <button type="submit" class="btn btn-primary btn-sm fw-semibold w-100 py-2">Lọc</button>
            <a href="{{ route('admin.claims.index') }}" class="btn btn-outline-secondary btn-sm py-2 px-3">Đặt lại</a>
        </div>
    </form>

    @if($claims->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-semibold">Không có yêu cầu nhận đồ nào trong mục này</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-2">Mã</th>
                        <th class="py-2">Người gửi yêu cầu</th>
                        <th class="py-2">Bài đăng đồ vật</th>
                        <th class="py-2" style="min-width: 280px; max-width: 380px;">Đặc điểm nhận dạng chứng minh</th>
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
                                <strong class="d-block text-dark">{{ $claim->user->name }}</strong>
                                <span class="text-muted" style="font-size: 0.75rem;">MSSV: {{ $claim->user->student_code ?? 'Chưa cập nhật' }}</span>
                                <div class="text-muted" style="font-size: 0.75rem;">SĐT: {{ $claim->user->phone ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <a href="{{ route('items.show', $claim->item) }}" target="_blank" class="fw-semibold text-dark text-decoration-none">
                                    {{ Str::limit($claim->item->title, 35) }}
                                </a>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    Đăng bởi: {{ $claim->item->user->name }}
                                </div>
                            </td>
                            <td style="min-width: 280px; max-width: 380px;">
                                <div class="p-2 bg-light rounded-2 border text-secondary" style="white-space: pre-wrap; font-size: 0.825rem; line-height: 1.5;">
                                    {{ $claim->message }}
                                </div>
                            </td>
                            <td>{{ $claim->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($claim->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Chờ duyệt</span>
                                @elseif($claim->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Đã duyệt – Trao trả</span>
                                @elseif($claim->status === 'rejected')
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Từ chối</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $claim->admin_note ?? 'Chưa có ghi chú' }}</small>
                            </td>
                            <td class="text-end">
                                @if($claim->status === 'pending')
                                    <button type="button" class="btn btn-primary btn-sm py-1 px-2 fw-medium text-nowrap" data-bs-toggle="modal" data-bs-target="#claimModal{{ $claim->id }}">
                                        Đối chiếu &amp; Xử lý
                                    </button>

                                    <!-- Modal Xử lý Claim -->
                                    <div class="modal fade text-start" id="claimModal{{ $claim->id }}" tabindex="-1" aria-labelledby="claimModalLabel{{ $claim->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-3 border-0 shadow">
                                                <form action="{{ route('admin.claims.handle', $claim) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title h6 fw-bold mb-0" id="claimModalLabel{{ $claim->id }}">Xử lý yêu cầu nhận đồ #{{ $claim->id }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
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
                                                            <label class="form-label fw-semibold text-secondary">Mô tả đặc điểm chứng minh của người gửi:</label>
                                                            <div class="p-2 bg-light rounded-2 border text-dark" style="white-space: pre-wrap;">
                                                                {{ $claim->message }}
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="claim_status_{{ $claim->id }}" class="form-label fw-semibold text-secondary">Quyết định phê duyệt <span class="text-danger">*</span></label>
                                                            <select name="status" id="claim_status_{{ $claim->id }}" class="form-select" required>
                                                                <option value="approved">Duyệt – Xác nhận đúng chủ sở hữu (Đổi tin sang Đã trả)</option>
                                                                <option value="rejected">Từ chối – Không trùng khớp đặc điểm nhận dạng</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="admin_note_{{ $claim->id }}" class="form-label fw-semibold text-secondary">Ghi chú của Admin (nếu có):</label>
                                                            <textarea name="admin_note" id="admin_note_{{ $claim->id }}" rows="3" class="form-control" placeholder="Ghi chú kết quả đối chiếu, hướng dẫn trao trả..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Hủy</button>
                                                        <button type="submit" class="btn btn-primary btn-sm fw-semibold px-4">Lưu kết quả</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border">Đã hoàn tất</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-top">
            {{ $claims->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

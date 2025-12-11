        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 通用删除确认
        function confirmDelete(message, callback) {
            Swal.fire({
                title: '您确定吗？',
                text: message || '此操作无法撤销！',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定删除！',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }
        
        // 显示成功消息
        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: '成功',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }
        
        // 显示错误消息
        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: '错误',
                text: message
            });
        }
    </script>
</body>
</html>
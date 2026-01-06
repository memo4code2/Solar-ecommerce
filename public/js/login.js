   function scrollToBottom() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Show the specified modal
        function showModal(modalType) {
            closeModal(); // Close any open modals
            
            if(modalType === 'login') {
                document.getElementById('loginModal').style.display = 'flex';
            }
            
            document.body.style.overflow = 'hidden';
        }

        // Close all modals
        function closeModal() {
            document.getElementById('loginModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                closeModal();
            }
        });

        // Close modal with ESC key
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
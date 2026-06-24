            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Active menu
        $(document).ready(function() {
            $('.sidebar a').each(function() {
                if ($(this).attr('href') == window.location.href) {
                    $(this).addClass('active');
                }
            });
        });
    </script>
</body>
</html>
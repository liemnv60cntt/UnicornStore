</div>
    
</body>
</html>
<script>
    $(document).ready(function() {
        $('.btn-spinner').on('click', e => {
            $('.spinner-border').removeClass('d-none');
            setTimeout(_ => $('.spinner-border').addClass('d-none'), 2000)
        })
    })
</script>
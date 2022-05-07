<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script>
    const logout = () => $.post('ajax.php',{action: 'logout'}, data => window.location.reload());
</script>
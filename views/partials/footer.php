
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajs.radius.africa/authx.js"></script>
<script type="text/javascript">
    function loginHandler (session, message) {
        console.log('logged in ', session, message)
        console.log('Session = ', authx.getSession())
    }
    const authx = AuthX("eEjFwAnbsYzUMWtWv8eJWp8hnDQdYrbkR0K2UKth", {
        redirect_uri: "http://authxapp.test",
        locale: 'en',
        isSpa: false,
        onComplete: loginHandler,
        onError: function (error) {
            alert(error.message)
        }
    })

    function login(e) {
        e.preventDefault();

        authx.initiateSession()
    }
    function hello() {
        alert('hello')
    }
</script>

</body>
</html>

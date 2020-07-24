<?php
$this->load->view('front/static/header') ?>
<body>
<div class="header" style="overflow: hidden; height:40px; width:auto;"><img
            src="<?php echo base_url('public/front/image/logo.png'); ?>" class="image" alt="logo" width="50"
            height="50"/></div>
<div class="container">

    <hr>

    <div class="row">
        <div class="col-lg-5 mx-auto">
            
            <h2>Giriş</h2>

            <div class="form-group mb-2">
                <label for="inputMail"><b>Email</b></label><br>
                <input type="text" class="form-control" name="email" id="inputMail">
            </div>

            <div class="form-group">
                <label for="inputPassword"><b>Password</b></label><br>
                <input type="password" class="form-control" name="password" id="inputPassword">
            </div>


                <div class="alert alert-danger" role="alert" id="errorMessage" style="display: none">

                </div>


            <div class="form-group d-flex justify-content-between">
                <div class="checkbox">
                    <label><input type="checkbox" id="check" style="border-radius:20px"> Beni Hatırla</label>
                </div>
                <a class="a" href="" target="_blank">Parolanı mı unuttun?</a>
            </div>
            <div class="col text-center">
                <button id="loginBtn" class="button" width="350px" name="gonder" style="border: 1px solid #43b2f8;">Giriş</button>
                <br>
            </div>
            <div class="register">
                <p id="kaydoll" style="font-weight:550">Hesabın yok mu?&nbsp<a class="kaydollink" href="#"
                                                                               target="_blank">Kaydol</a></p>
            </div>


        </div>
    </div>

</div>
<?php $this->load->view('front/static/footer') ?>

<script>
    $(document).ready(function () {
        $('#loginBtn').click(function () {
            const username = $('#inputMail').val();
            const password = $('#inputPassword').val();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('ajaxLogin') ?>",
                data: { username, password },
                success: function (response) {
                    if (response.code == 1){
                        $('#errorMessage').removeClass();
                        $('#errorMessage').addClass('success alert-success');
                        $('#errorMessage').show();
                        $('#errorMessage').html(response.msg);

                        window.location.href = "<?php echo base_url(''); ?>";

                    }else {
                        $('#errorMessage').show();
                        $('#errorMessage').html(response.msg);
                    }
                }
            });

        })
    })

</script>
</body>
</html>

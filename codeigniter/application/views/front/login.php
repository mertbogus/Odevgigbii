<?php
$this->load->view('front/static/header') ?>
<body>
<div class="header" style="overflow: hidden; height:40px; width:auto;"><img src="<?php echo base_url('public/front/image/logo.png');?>" class="image" alt="logo" width="50" height="50"/></div>
<div class="container">

    <hr>

    <div class="row">
        <div class="col-lg-5 mx-auto">
            <form class="form_group" style="overflow: hidden;border:solid 0px #6E6D6D" method="post" action="">
                <h2>Giriş</h2>

                <div class="form-group mb-2">
                    <label for="inputMail"><b>Email</b></label><br>
                    <input type="text" class="form-control" name="email" id="inputMail">
                </div>

                <div class="form-group">
                    <label for="inputPassword"><b>Password</b></label><br>
                    <input type="password" class="form-control" name="password" id="inputPassword">
                </div>

                <?php if (!empty($message)){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $message ?>
                </div>
                <?php } ?>

                <div class="form-group d-flex justify-content-between">
                    <div class="checkbox">
                        <label><input type="checkbox" id="check" style="border-radius:20px"> Beni Hatırla</label>
                    </div>
                    <a class="a" href="" target="_blank">Parolanı mı unuttun?</a>
                </div>
                 <div class="col text-center">
                <button type="submit" class="button" width="350px" name="gonder">Giriş</button><br>
                 </div>
                <div class="kaydol">
                    <p id="kaydoll" style="font-weight:550">Hesabın yok mu?&nbsp<a class="kaydollink" href="#" target="_blank">Kaydol</a></p>
                </div>

            </form>

        </div>
    </div>

</div>
<?php $this->load->view('front/static/footer') ?>
</body>
</html>

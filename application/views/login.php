<div class="log-reg-v3 content-md">
    <div class="container">
        <div class="row">
            <h1 class="heading">
                <?php echo $page_var['title']; ?>
            </h1>

            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <form id="login_form" class="log-reg-block sky-form form" action="<?php echo base_url('user/loginUser'); ?>">

                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="email" placeholder="Email Address" name="email" class="form-control">
                            </div>
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" placeholder="Password" name="password" class="form-control">
                            </div>
                        </label>
                    </section>
                    <button class="btn btn-success btn-block margin-bottom-20 rounded" type="submit">Log in</button>
                    <div class="row margin-bottom-5">
                        <div class="col-xs-12 text-center">
                            <a href="<?php echo base_url('forgot-password') ?>">Forgot your Password?</a>
                        </div>
                    </div>
                    <hr/>
                    <p class="text-center">Don't have account yet? Learn more and <a href="<?php echo base_url('register') ?>">Sign Up</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
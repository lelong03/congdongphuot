<style type="text/css">
body#global_page_core-index-index span#global_content_simple
{
    width: 100%;
}
body#global_page_core-index-index div.layout_core_menu_footer
{
    background-color: #3b3b3b;
    clear: both;
    margin: 0 auto;
    overflow: hidden;
    padding-left: 14%;
    padding-top: 30px;
    padding-bottom: 30px;
}
body#global_page_core-index-index div.layout_core_menu_footer form
{
    display: none !important;
}
body
{
	text-align: center;
}

#site_landing_page_top {
	height: 64px;
    background: #007457;
}

#site_landing_page_top .logo{
    float: left;
    margin-left: 14%;
    margin-top: 4px;
}

#site_landing_page_top .logo .logo_simple{
	height: 60px;
}

#site_landing_page_top .menu_login_container{
	float: right;
	margin-right: 14%;
    margin-top: 12px;
}

#site_landing_page_top .menu_login_container .html7magic {
    padding-bottom: 4px;
}

#site_landing_page_top .menu_login_container table tr td {
    padding: 0px 0px 0px 14px;
}

.menu_login_container .html7magic label {
    font-weight: normal;
    padding-left: 1px;
    font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
    color: white;
	font-size: 11px;
}
.menu_login_container .login_form_label_field, .menu_login_container .login_form_label_field label
{
	font-size: 11px;
	color: white;	
}

#site_landing_page_banner {
	width: 100%;
	min-height: 322px;
	
	background: url(<?php echo $this->baseUrl();?>/application/themes/grid-green/images/congdongphuot/landing_bg2.jpg);
	
	background-position: center center;
	height: auto;
	background-size: cover;
}

#site_landing_page_banner .global_form>div {
	float: right;
	opacity: 0.6;
	background-color: white;
	margin-right: 14%;
	margin-top: 20px; 
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	border-radius: 2px;
}

#site_landing_page_banner .global_form>div>div {
	background-color: white;
	border: 0px solid white;
    padding: 25px;
}

#site_landing_page_banner .global_form div.form-label {
	width: 97px;
	color: black;
}

#site_landing_page_banner .global_form button#submit {
	background: green;
}

body#global_page_core-index-index .global_form select
{
    max-width: 208px;;
}
form#login_form
{
	float: left;
}
</style>


<div id="site_landing_page_top">
	<div class="top">
		<div class="logo">
			<a href="http://congdongphuot.com/">
				<img skinpart="image" class="logo_simple" alt="" src="<?php echo $this->baseUrl();?>/application/themes/grid-green/images/congdongphuot/logo.png" />
			</a>
		</div>
		<div class="title">
			
		</div>
		<div class="menu_login_container">
			<form id="login_form" action="<?php echo $this->formLogin->getAction();?>" method="post">
				<table role="presentation" cellspacing="0">
					<tbody>
						<tr>
							<td>
								<input type="email" name="email" id="email" value="" tabindex="1" autofocus="autofocus" class="text" placeholder="email">
							</td>
							<td>
								<input type="password" name="password" id="password" value="" tabindex="2" placeholder="password">
							</td>
							<td rowspan=2>
									<button style="height: 40px;" name="submit" id="submit" type="submit" tabindex="4">Đăng nhập</button>
							</td>
						</tr>
						<tr>
							<td class="login_form_label_field">
								<div>
									<div class="clearfix">
										<input type="checkbox" name="remember" id="remember" value="1" tabindex="3">
										<label for="persist_box">Ghi nhớ</label>
									</div>
								</div>
							</td>
							<td class="login_form_label_field">
								<a href="<?php echo $this->baseUrl() ?>/user/auth/forgot" style="color: white;">Quên mật khẩu?</a>
							</td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="return_url" value="" id="return_url">
			</form>

			<a href="/user/auth/facebook" style="float: left;margin-left: 5px;margin-top: -1px;" title="Đăng nhập bằng Facebook">
						<img src="/application/themes/grid-green/images/congdongphuot/facebook.png" border="0" alt="Connect with Facebook" style="width: 41px;" />
			</a>

		</div>
	</div>
</div>

<div id="site_landing_page_banner">
<div>
	<?php echo $this->formSignup -> setTitle("") -> render();?>
</div>
</div>
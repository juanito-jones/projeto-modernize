<style>
	.contact-form {
		position: relative;
		background: #fff;
	}
	.contact-form input[type="text"], .contact-form textarea {
		padding-right: 30px;
		border: 1px solid #DEDEDE;
		margin-bottom: 0;
		font-size: 14px;
	}
	form .error {
		border-color: #e1534f !important;
	}
	.contact-form textarea {
		height: 202px;
	}
	.contact-form input[type="text"] {
		display: block;
		height: 46px;
		margin-bottom: 32px;
		width: 100%;
		font-size: 14px;
		padding: 0 15px;
		border: 1px solid #e5e5e5;
		color: #878787;
		background: transparent;
		-webkit-appearance: none;
		border-radius: 0;
	}
	.contact-form input[type="text"]:focus, .contact-form textarea:focus {
		border: 1px solid #6aaf08;
	}
	.form-full {
		width: 100%;
	}
</style>
<div class="container contact-form text-center pt-80 pt-xs-60 mt-up">
	<div class="row">
		<div class="col-sm-12">
			<div class="headeing pb-20">
				<h2>Get in Touch</h2>
				<span class="b-line"></span>
			</div>
			<p>
				Nullam dictum felis eu pede mollis pretium.
			</p>
			<!-- Contact FORM -->
			<form class="contact-form mt-45" id="contact">
				<!-- IF MAIL SENT SUCCESSFULLY -->
				<div id="success">
					<div role="alert" class="alert alert-success">
						<strong>Thanks</strong> for using our template. Your message has been sent.
					</div>
				</div>
				<!-- END IF MAIL SENT SUCCESSFULLY -->
				<div class="row">
					<div class="col-md-12 col-lg-6">
						<div class="form-field">
							<input class="input-sm form-full" id="name" type="text" name="form-name" placeholder="Your Name">
						</div>
						<div class="form-field">
							<input class="input-sm form-full" id="email" type="text" name="form-email" placeholder="Email" >
						</div>
						<div class="form-field">
							<input class="input-sm form-full" id="sub" type="text" name="form-subject" placeholder="Subject">
						</div>
					</div>
					<div class="col-md-12 col-lg-6">
						<div class="form-field">
							<textarea class="form-full" id="message" rows="7" name="form-message" placeholder="Your Message" ></textarea>
						</div>
					</div>
					<div class="col-sm-12 mt-30">
						<button class="btn-text" type="button" id="submit" name="button">
							Send Message
						</button>
					</div>
				</div>
			</form>
			<!-- END Contact FORM -->
		</div>
	</div>
</div>
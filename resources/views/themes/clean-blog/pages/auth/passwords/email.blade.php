@extends('themes.clean-blog.layouts.default')

@section("header")
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('/img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Affiliate Reset</h1>
                        <hr class="small">
                        <span class="subheading"></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

<!-- Main Content -->
@section('content')
<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
  <h2>Reset Password</h2>
  @if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
  @endif
  <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
    <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
    <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
    <form role="form" method="POST" action="{{ url('/password/email') }}">
        <div class="row control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
                <label>邮箱</label>
                <input type="email" id="email" placeholder="邮箱 *" class="form-control" name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <br>
        <div class="row">
            <div class="form-group col-xs-12">
                <button type="submit" class="btn btn-default">
                  <i class="fa fa-btn fa-envelope"></i> 发送重置邮件
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

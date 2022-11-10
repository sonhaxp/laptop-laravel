@extends('Shared.layout');
@section('title', 'Phản hồi')
@section('content')
<!-- breadcrumb area start -->
<div class="breadcrumb-area mb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/trang-chu">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Phản hồi</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact-two-area pt-60 pb-70">
    <div class="container-fluid">
         <div class="row">
             <div class="col-12">
                 <div class="contact2-title text-center mb-60">
                     <h2>Phản hồi của bạn</h2>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-12">
                 <div class="contact-message">
                     <form action="sendFeedback" method="post" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                @if ($errors->has('login')==true)
                                <div class="login-box mt-5 text-center">
                                    <p style="color:red"><strong>{{ $errors->first('login') }}</strong></p>
                                </div>    
                                @endif
                                @if ($errors->has('success')==true)
                                    <div class="login-box mt-5 text-center">
                                        <p style="color:rgb(98, 248, 98)"><strong>{{ $errors->first('success') }}</strong></p>
                                    </div>    
                                @endif
                            </div>
                            <div class="col-12">
                                 <div class="contact2-textarea text-center">
                                     <textarea placeholder="Phản hồi *" name="message"  class="form-control2" required="" maxlength="256"></textarea>     
                                 </div>   
                                 <div class="contact-btn text-center">
                                     <button class="btn btn-secondary" type="submit">Send Message</button> 
                                 </div> 
                             </div> 
                        </div>
                     </form>    
                 </div> 
            </div>
        </div>
    </div>
</div>

@endsection
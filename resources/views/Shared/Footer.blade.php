
<!-- scroll to top -->
<div class="scroll-top not-visible">
    <i class="fa fa-angle-up"></i>
</div> <!-- /End Scroll to Top -->
<!-- footer area start -->
<footer>
    <!-- footer top area start -->
    <div class="footer-top pt-50 pb-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-single-widget">
                        <div class="widget-title">
                            <div class="footer-logo mb-30">
                                <a href="index.html">
                                    <img src="{{ URL::asset('images/logo/logo-TS.jpg') }}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="payment-method">
                                <h4>Thanh toán</h4>
                                <img src="{{ URL::asset('images/payment/payment.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div> <!-- single widget end -->
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-single-widget">
                        <div class="widget-title">
                            <h4>Thông tin</h4>
                        </div>
                        <div class="widget-body">
                            <div class="footer-useful-link">
                                <ul>
                                    <li><a href="{{ URL::asset('/gioi-thieu') }}">Chúng tôi</a></li>
                                    <li><a href="{{ URL::asset('/thong-tin') }}">Thông tin giao hàng</a></li>
                                    <li><a href="{{ URL::asset('/gioi-thieu') }}">Chính sách</a></li>
                                    <li><a href="{{ URL::asset('/gioi-thieu') }}">Điều khoản và điều kiện</a></li>
                                    <li><a href="{{ URL::asset('/lien-he') }}">Liên hệ chúng tôi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- single widget end -->
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-single-widget">
                        <div class="widget-title">
                            <h4>Liên hệ</h4>
                        </div>
                        <div class="widget-body">
                            <div class="footer-useful-link">
                                <ul>
                                    <li><span>Địa chỉ:</span> {{ $configSite->Place }}</li>
                                    <li><span>Email:</span><a href="mailto:{{ $configSite->Email }}"> {{ $configSite->Email }}</a></li>
                                    <li><span>Điện thoại:</span><a href="tel:+{{ $configSite->Hotline }}"> <strong>{{ $configSite->Hotline }}</strong></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- single widget end -->
                
            </div>
        </div>
    </div>
    <!-- footer top area end -->
    <!-- footer bottom area start -->
    <div class="footer-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom-content">
                        <div class="footer-copyright">
                            <p>&copy; 2022 <b>TS Laptop</b> Made with <i class="fa fa-heart text-danger"></i> by <b>TS</b></p>
                        </div>
                        <div class="footer-custom-link">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer bottom area end -->
</footer>
<!-- footer area end -->

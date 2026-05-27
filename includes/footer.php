<!-- =========================
FILE: includes/footer.php
========================= -->

<!-- LOCATIONS ROW STYLES (footer-scoped) -->
<style>
    .footer-locations{
        padding:50px 0 10px;
        border-top:1px solid rgba(255,255,255,0.06);
        margin-top:60px;
    }
    .footer-locations .loc-heading{
        text-align:center;
        margin-bottom:35px;
    }
    .footer-locations .loc-heading .eyebrow{
        display:inline-block;
        color:#ff2d55;
        background:rgba(255,45,85,0.10);
        padding:6px 16px;
        border-radius:50px;
        font-size:12px;
        font-weight:600;
        letter-spacing:2px;
        text-transform:uppercase;
        margin-bottom:14px;
    }
    .footer-locations .loc-heading h4{
        color:#fff;
        font-size:26px;
        font-weight:700;
        margin:0;
    }
    .footer-locations .loc-heading h4 span{
        color:#ff2d55;
    }
    .footer-locations .loc-grid{
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:14px;
    }
    .footer-locations .loc-grid a{
        display:flex;
        align-items:center;
        gap:12px;
        padding:14px 18px;
        background:rgba(255,255,255,0.03);
        border:1px solid rgba(255,255,255,0.06);
        border-radius:12px;
        color:#dcdcdc;
        font-size:15px;
        font-weight:500;
        text-decoration:none;
        transition:all 0.3s ease;
        position:relative;
        overflow:hidden;
    }
    .footer-locations .loc-grid a::before{
        content:'';
        position:absolute;
        left:0; top:0;
        height:100%;
        width:3px;
        background:#ff2d55;
        transform:scaleY(0);
        transform-origin:bottom;
        transition:transform 0.3s ease;
    }
    .footer-locations .loc-grid a i{
        color:#ff2d55;
        font-size:13px;
        transition:0.3s;
    }
    .footer-locations .loc-grid a:hover{
        background:rgba(255,45,85,0.10);
        border-color:rgba(255,45,85,0.4);
        color:#fff;
        transform:translateY(-3px);
        box-shadow:0 10px 25px rgba(255,45,85,0.15);
    }
    .footer-locations .loc-grid a:hover::before{
        transform:scaleY(1);
    }
    .footer-locations .loc-grid a:hover i{
        color:#fff;
        transform:scale(1.2);
    }
    @media(max-width:991px){
        .footer-locations .loc-grid{grid-template-columns:repeat(3,1fr)}
    }
    @media(max-width:767px){
        .footer-locations{padding:40px 0 0}
        .footer-locations .loc-grid{grid-template-columns:repeat(2,1fr);gap:10px}
        .footer-locations .loc-grid a{padding:12px 14px;font-size:14px}
        .footer-locations .loc-heading h4{font-size:22px}
    }
</style>

<!-- FOOTER START -->
<footer class="main-footer">

    <div class="container">

        <div class="row gy-5">

            <div class="col-lg-4">

                <div class="footer-about">

                    <a href="#" class="footer-logo">
                        Swapna<span>Vennam</span>
                    </a>

                    <p>
                        Premium escort service platform in Hyderabad offering luxury companionship experiences.
                    </p>

                </div>

            </div>

            <div class="col-lg-2 col-md-6">

                <div class="footer-widget">

                    <h5>Quick Links</h5>

                    <ul>

                        <li><a href="#">Home</a></li>
                        <li><a href="#">Escorts</a></li>
                        <li><a href="#">Cities</a></li>
                        <li><a href="#">Contact</a></li>

                    </ul>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="footer-widget">

                    <h5>Popular Categories</h5>

                    <ul>

                        <li><a href="#">VIP Escorts</a></li>
                        <li><a href="#">Independent Girls</a></li>
                        <li><a href="#">Romantic Dates</a></li>
                        <li><a href="#">Night Services</a></li>

                    </ul>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="footer-widget">

                    <h5>Contact Us</h5>

                    <ul class="footer-contact">

                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            Hyderabad, India
                        </li>

                        <li>
                            <i class="fa-solid fa-phone"></i>
                            +91 0000000000
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- ============================================ -->
        <!-- LOCATIONS ROW - 12 PREMIUM HYDERABAD AREAS  -->
        <!-- ============================================ -->
        <div class="footer-locations">

            <div class="loc-heading">

                <span class="eyebrow">
                    <i class="fa-solid fa-location-dot me-1"></i>
                    Coverage Areas
                </span>

                <h4>
                    Premium Escort Service Across <span>Hyderabad</span>
                </h4>

            </div>

            <div class="loc-grid">

                <a href="locations/kondapur.php">
                    <i class="fa-solid fa-map-pin"></i> Kondapur
                </a>

                <a href="locations/hitech-city.php">
                    <i class="fa-solid fa-map-pin"></i> Hitech City
                </a>

                <a href="locations/gachibowli.php">
                    <i class="fa-solid fa-map-pin"></i> Gachibowli
                </a>

                <a href="locations/banjara-hills.php">
                    <i class="fa-solid fa-map-pin"></i> Banjara Hills
                </a>

                <a href="locations/madhapur.php">
                    <i class="fa-solid fa-map-pin"></i> Madhapur
                </a>

                <a href="locations/jubilee-hills.php">
                    <i class="fa-solid fa-map-pin"></i> Jubilee Hills
                </a>

                <a href="locations/somajiguda.php">
                    <i class="fa-solid fa-map-pin"></i> Somajiguda
                </a>

                <a href="locations/shamshabad.php">
                    <i class="fa-solid fa-map-pin"></i> Shamshabad
                </a>

                <a href="locations/begumpet.php">
                    <i class="fa-solid fa-map-pin"></i> Begumpet
                </a>

                <a href="locations/lakdikapul.php">
                    <i class="fa-solid fa-map-pin"></i> Lakdikapul
                </a>

                <a href="locations/masab-tank.php">
                    <i class="fa-solid fa-map-pin"></i> Masab Tank
                </a>

                <a href="locations/panjagutta.php">
                    <i class="fa-solid fa-map-pin"></i> Panjagutta
                </a>

            </div>

        </div>
        <!-- LOCATIONS ROW END -->

        <div class="footer-bottom">

            <p>
                &copy; 2026 Swapnavennam. All Rights Reserved.
            </p>

        </div>

    </div>

</footer>
<!-- FOOTER END -->


<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

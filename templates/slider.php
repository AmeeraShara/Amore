    <!-- SLIDER -->
    <section class="section-slider height-v">
        <div id="index12" class="owl-carousel  owl-theme">
            <div class="item">
                <img alt="" src="images/slider/slider-1.jpg" class="img-responsive">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Hotel Amore</h1>
                        <p><span class="line-t"></span>Hotels & Resorts <span class="line-b"></span></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img alt="" src="images/slider/slider-2.jpg" class="img-responsive">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Life Long Memory</h1>
                        <p><span class="line-t"></span>Just a few seconds away<span class="line-b"></span></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img alt="" src="images/slider/slider-3.jpg" class="img-responsive">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Uniquely Peaceful</h1>
                        <p><span class="line-t"></span>Beautifuly restful<span class="line-b"></span></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img alt="" src="images/slider/slider-4.jpg" class="img-responsive">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Luxury Destinations</h1>
                        <p><span class="line-t"></span>Anything but Odinary<span class="line-b"></span></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img alt="" src="images/slider/slider-6.jpg" class="img-responsive">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Magical Memories</h1>
                        <p><span class="line-t"></span>Bespoke experiences<span class="line-b"></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="check-avail">
            <div class="container">
                <div class="arrival date-title ">
                    <label>Arrival Date </label>
                    <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                        <input class="form-control" type="text" id="arrival">
                        <span class="input-group-addon"><img src="images/home/date-icon.png" alt="#"></span>
                    </div>
                </div>
                <div class="departure date-title ">
                    <label>Departure Date </label>
                    <div id="datepickeri" class="input-group date" data-date-format="yyyy-mm-dd">
                        <input class="form-control" type="text" id="departure">
                        <span class="input-group-addon"><img src="images/home/date-icon.png" alt="#"></span>
                    </div>
                </div>
                <div class="adults date-title ">
                    <label>Adults</label>
                    <form>
                        <div class=" carousel-search">
                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">-</a>
                                <ul class="dropdown-menu" id="adults">
                                    <li value="1"><a>1</a></li>
                                    <li value="2"><a>2</a></li>
                                    <li value="3"><a>3</a></li>
                                    <li value="4"><a>4</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="children date-title ">
                    <label>Children</label>
                    <form>
                        <div class=" carousel-search">
                            <div class="btn-group">
                                <a class="btn dropdown-toggle " data-toggle="dropdown" href="#">-</a>
                                <ul class="dropdown-menu" id="children">
                                    <li value="1"><a>1</a></li>
                                    <li value="2"><a>2</a></li>
                                    <li value="3"><a>3</a></li>
                                    <li value="4"><a>4</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="find_btn date-title">
                    <div class="text-find" onclick="checkAvailability()">
                        Check
                        <br>Availability
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END / SLIDER -->
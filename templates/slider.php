    <!-- SLIDER -->


<!-- SLIDER -->
<section class="section-slider height-v" style="position: relative; height: 750px; overflow: hidden;">
    <div id="index1" class="owl-carousel owl-theme">
        <div class="item">
            <img src="images/slider/font.jpg" alt="" class="img-responsive"
                 style="width: 100%; height: 740px; object-fit: cover; transform: scale(1); transition: transform 2s ease-in-out;">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Hotel Amore</h1>
                    <p><span class="line-t"></span>RELAX , DINE & REJUVENATE <span class="line-b"></span></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="images/slider/hotel.jpg" alt="" class="img-responsive"
                 style="width: 100%; height: 740px; object-fit: cover; transform: scale(1); transition: transform 2s ease-in-out;">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Elegant Lobby</h1>
                    <p><span class="line-t"></span>WARM WELCOME<span class="line-b"></span></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="images/slider/sea.jpg" alt="" class="img-responsive"
                 style="width: 100%; height: 740px; object-fit: cover; transform: scale(1); transition: transform 2s ease-in-out;">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Sea View</h1>
                    <p><span class="line-t"></span>BREATHTAKING OCEAN VISITS <span class="line-b"></span></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="images/slider/cozy.jpg" alt="" class="img-responsive"
                 style="width: 100%; height: 740px; object-fit: cover; transform: scale(1); transition: transform 2s ease-in-out;">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Cozy Rooms</h1>
                    <p><span class="line-t"></span>RESTFUL NIGHTS <span class="line-b"></span></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="images/slider/lakes.jpg" alt="" class="img-responsive"
                 style="width: 100%; height: 740px; object-fit: cover; transform: scale(1); transition: transform 2s ease-in-out;">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Lakeside</h1>
                    <p><span class="line-t"></span>RELAX & UNWIND<span class="line-b"></span></p>
                </div>
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
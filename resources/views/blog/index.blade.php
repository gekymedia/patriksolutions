@extends('blog.components.base')
@section('title', 'Patrik Solutions')
@section('home-active', 'active')
@section('content')

    <!-- HOME -->
    <section id="home">
        <div class="row">
            <div class="owl-carousel owl-theme home-slider">
                <div class="item item-first">
                    <div class="caption">
                        <div class="container">
                            <div class="col-md-6 col-sm-12">
                                <h1>Welcome to Patrik Solutions, your ultimate destination for mastering financial literacy!
                                </h1>
                                <h3>Whether you're just starting your financial journey or looking to enhance your money
                                    management skills, you're in the right place.</h3>
                                <a href="{{ route('blog-posts') }}" class="section-btn btn btn-default">Read Blog</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item item-second">
                    <div class="caption">
                        <div class="container">
                            <div class="col-md-6 col-sm-12">
                                <h1>Do you need more insights on finanicial freedom?</h1>
                                <h3>We are here for you. </h3>
                                <a href="{{ route('blog-posts') }}" class="section-btn btn btn-default">Read Blog</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div id="editor"></div> -->
                <div class="item item-third">
                    <div class="caption">
                        <div class="container">
                            <div class="col-md-6 col-sm-12">
                                <h1>Educational Articles:</h1>
                                <h3>Explore our library of in-depth articles covering topics such as budgeting, saving,
                                    investing, debt management, and more.</h3>
                                <a href="{{ route('blog-posts') }}" class="section-btn btn btn-default">Read Blog</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section>
            <div class="container">
				<div class="text-center">
            <h1>Tax Filing Services</h1>
            <br>
            <p class="lead">
                At Patrik Solutions, we provide expert assistance with your tax filing needs. Contact us today and let us help you navigate the complexities of tax filing with ease and confidence.
            </p>
            <h2>
                            <p class="lead">Reach out to us for more information:</p>
                            <ul class="list-unstyled">
                                <li><strong>Phone:</strong> 202-590-1404</li>
                                <li><strong>Email:</strong> <a href="mailto:patriksolutions@gmail.com">patriksolutions@gmail.com</a></li>
                            </ul>
                            <p>
                                Our team is ready to assist you with any inquiries or concerns about your taxes. Get in touch, and let us simplify the process for you!
                            </p>
                        </h2>
        </div>
                <div class="row">
                    @foreach ($youtubes as $youtube)
                        <div class="col-md-6 col-sm-6">
                            <style>
                                .auto-resizable-iframe {
                                    max-width: 420px;
                                    margin: 0px auto;
                                }

                                .auto-resizable-iframe>div {
                                    position: relative;
                                    padding-bottom: 75%;
                                    height: 0px;
                                }

                                .auto-resizable-iframe iframe {
                                    position: absolute;
                                    top: 0px;
                                    left: 0px;
                                    width: 100%;
                                    height: 100%;
                                }
                            </style>
                            {!! $youtube->url !!}

                        </div>
                    @endforeach
                    {{-- <div class="col-md-6 col-sm-6">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/ZBc2TfxOAGs?si=5A_bNAEAXfnBTL2J" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
               </div> --}}
                </div>

                {{-- <div class="col-md-6">
                   {!! $youtube->url !!}
               </div> --}}

                {{-- <div class="col-md-6">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/jz2jB785N2c?si=igfPbjklzW26ay6z" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
               </div>
           --}}
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="text-center">
                            <h2>About us</h2>

                            <br>

                            <p class="lead">Certainly! Here's a short "About Us" section for Patrik Solutions:

                                "At Patrik Solutions, we believe in the power of financial literacy to transform lives. Our
                                platform is dedicated to providing individuals with the knowledge, tools, and support they
                                need to take control of their finances and build a secure future. Whether you're looking to
                                master the basics of budgeting, explore investment opportunities, or tackle debt, we're here
                                to guide you every step of the way. With expert advice, interactive tools, and a vibrant
                                community, Patrik Solutions is your trusted partner on the journey to financial
                                empowerment.".</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="section-title text-center">
                            <h2>Latest Blog posts <small>Check out our latest blogs posts.</small></h2>
                        </div>
                    </div>

                    {{-- <div class="col-md-4 col-sm-4">
                        <div class="courses-thumb courses-thumb-secondary">
                            <div class="courses-top">
                                <div class="courses-image">
                                    <img src="images/product-1-720x480.jpg" class="img-responsive" alt="">
                                </div>
                                <div class="courses-date">
                                    <span title="Author"><i class="fa fa-user"></i> John Doe</span>
                                    <span title="Date"><i class="fa fa-calendar"></i> 12/06/2020 10:30</span>
                                    <span title="Views"><i class="fa fa-eye"></i> 114</span>
                                </div>
                            </div>

                            <div class="courses-detail">
                                <h3><a href="blog-post-details.html">Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit.</a></h3>
                            </div>

                            <div class="courses-info">
                                <a href="blog-post-details.html" class="section-btn btn btn-primary btn-block">Read More</a>
                            </div>
                        </div>
                    </div> --}}

                    @foreach ($blogs as $blog)
                        <div class="col-md-4 col-sm-4">
                            <div class="courses-thumb courses-thumb-secondary">
                                <div class="courses-top">
                                    <div class="courses-image">
                                        <img src="{{ asset('storage/' . $blog->blog_thumbnail) }}" class="img-responsive"
                                            alt="">
                                    </div>
                                    <div class="courses-date">
                                        <span title="Author"><i class="fa fa-user"></i> {{ $blog->blog_author }}</span>
                                        <span title="Date"><i class="fa fa-calendar"></i> {{ $blog->created_at }}</span>
                                        <span title="Views"><i class="fa fa-eye"></i> {{ $blog->blog_view }}</span>
                                    </div>
                                </div>

                                <div class="courses-detail">
                                    <h3><a href="{{ route('blog-details', $blog->id) }}">{{ $blog->blog_title }}</a></h3>
                                </div>

                                <div class="courses-info">
                                    <a href="{{ route('blog-details', $blog->id) }}"
                                        class="section-btn btn btn-primary btn-block">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- <div class="col-md-4 col-sm-4">
                        <div class="courses-thumb courses-thumb-secondary">
                            <div class="courses-top">
                                <div class="courses-image">
                                    <img src="images/product-3-720x480.jpg" class="img-responsive" alt="">
                                </div>
                                <div class="courses-date">
                                    <span title="Author"><i class="fa fa-user"></i> John Doe</span>
                                    <span title="Date"><i class="fa fa-calendar"></i> 12/06/2020 10:30</span>
                                    <span title="Views"><i class="fa fa-eye"></i> 114</span>
                                </div>
                            </div>

                            <div class="courses-detail">
                                <h3><a href="blog-post-details.html">A voluptas ratione, error provident distinctio, eaque
                                        id officia?</a></h3>
                            </div>

                            <div class="courses-info">
                                <a href="blog-post-details.html" class="section-btn btn btn-primary btn-block">Read More</a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
    </main>

    <!-- CONTACT -->
    <section id="contact">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-sm-12">
                    <form id="contact-form" role="form" action="" method="post">
                        <div class="section-title">
                            <h2>Contact us <small>we love conversations. let us talk!</small></h2>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <input type="text" class="form-control" placeholder="Enter full name" name="name"
                                required>

                            <input type="email" class="form-control" placeholder="Enter email address" name="email"
                                required>

                            <textarea class="form-control" rows="6" placeholder="Tell us about your message" name="message" required></textarea>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <input type="submit" class="form-control" name="send message" value="Send Message">
                        </div>

                    </form>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="contact-image">
                        <img src="images/contact-1-600x400.jpg" class="img-responsive" alt="Smiling Two Girls">
                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection

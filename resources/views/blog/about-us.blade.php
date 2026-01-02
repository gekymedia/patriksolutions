@extends('blog.components.base')
@section('title', 'Patrick Solutions | About')
@section('about-active', 'active')
@section('content')
<section>
     <div class="container">
          <div class="text-center">
               <h1>About Us</h1>
               <br>
               <p class="lead">Welcome to Patrik Solutions, your trusted partner in financial literacy and empowerment. At Patrik Solutions, we are dedicated to transforming the way individuals and businesses understand and manage their finances. Our mission is simple yet profound: to equip our clients with the knowledge, tools, and strategies necessary to achieve financial independence and security.</p>
          </div>
     </div>
</section>

<section class="section-background">
     <div class="container">
          <div class="row">
               <div class="col-md-offset-1 col-md-4 col-xs-12 pull-right">
                    <img src="{{asset('assets/images/about-1-720x720.jpg')}}" class="img-responsive img-circle" alt="">
               </div>

               <div class="col-md-7 col-xs-12">
                    <div class="about-info">
                         <h2></h2>

                         <figure>
                              <figcaption>
                                   <p>Founded with a passion for educating and empowering, Patrik Solutions stands at the forefront of the financial literacy movement. We believe that everyone deserves access to reliable and practical financial education, regardless of their background or current financial situation. Through our comprehensive resources and personalized guidance, we aim to demystify complex financial concepts and foster a culture of informed decision-making.</p>
                              </figcaption>
                         </figure>
                    </div>
               </div>
          </div>
     </div>
</section>

<section>
     <div class="container">
          <div class="row">
               <div class="col-md-4 col-xs-12">
                    <img src="{{asset('assets/images/patrikbarfi.jpg')}}" class="img-responsive img-circle" alt="">
               </div>

               <div class="col-md-offset-1 col-md-7 col-xs-12">
                    <div class="about-info">
                         <h2>What sets Patrik Solutions</h2>

                         <figure>
                              <figcaption>
                                   <p>What sets Patrik Solutions apart is our commitment to integrity, expertise, and personalized service. Our team comprises seasoned financial professionals who bring years of industry experience and a genuine desire to see our clients succeed. Whether you are an individual looking to manage debt, plan for retirement, or invest wisely, or a business striving for financial health and growth, Patrik Solutions is here to support you every step of the way.</p>

                                   <p>Our approach is rooted in collaboration and tailored solutions. We take the time to understand your unique financial goals and challenges, offering customized strategies that align with your aspirations. Through workshops, seminars, one-on-one consultations, and digital resources, we empower you to take control of your financial future with confidence..</p>
                              </figcaption>
                         </figure>
                    </div>
               </div>
          </div>
     </div>
</section>

<section class="section-background">
     <div class="container">
          <div class="row">
               <div class="col-md-12 col-sm-12">
                    <div class="text-center">
                         <h2>What we believe in</h2>

                         <br>

                         <p >At Patrik Solutions, we believe that financial literacy is not just about numbers—it's about empowering individuals and businesses to make informed decisions that lead to lasting prosperity. Join us on this journey towards financial wellness and discover how knowledge, guidance, and empowerment can transform your life.</p>
                    </div>
               </div>
          </div>
     </div>
</section>

@endsection
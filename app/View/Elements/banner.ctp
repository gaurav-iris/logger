<!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide home" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>

      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <?php echo $this->Html->image("banner1.jpg"); ?>
          <div class="container">
            <div class="carousel-caption black">
              <h1>Why do we use it?</h1>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
              <p><a class="btn btn-lg btn-black" href="#" role="button">Sign in</a><a class="btn btn-lg btn-primary" href="#" role="button">Sign up </a></p>
            </div>
          </div>
        </div>
            <div class="item">
          <?php echo $this->Html->image("banner2.jpg"); ?>
          <div class="container">
            <div class="carousel-caption black">
              <h1>Why do we use it?</h1>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
              <p><a class="btn btn-lg btn-black" href="#" role="button">Sign in</a><a class="btn btn-lg btn-primary" href="#" role="button">Sign up </a></p>
            </div>
          </div>
        </div>
            <div class="item">
          <?php echo $this->Html->image("banner3.jpg"); ?>
          <div class="container">
            <div class="carousel-caption">
              <h1>Why do we use it?</h1>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
              <p><a class="btn btn-lg btn-black" href="#" role="button">Sign in</a><a class="btn btn-lg btn-primary" href="#" role="button">Sign up </a></p>
            </div>
          </div>
        </div>
<!--        <div class="item">
          <img src="images/banner2.jpg" alt="First slide"/>

        </div>
        <div class="item">
          <img src="images/banner3.jpg" alt="Second slide"/>
        </div>-->
        

      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->
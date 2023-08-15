<?php

use App\Page;

$baseballisms = [
  '"It ain’t over till it’s over." ~ Yogi Berra',
  '"You can observe a lot by just watching." ~ Yogi Berra',
  '"Baseball is 90% mental and the other half is physical." ~ Yogi Berra',
  '"I knew the record would stand until it was broken." ~ Yogi Berra',
  '"How can you think and hit at the same time?" ~ Yogi Berra',
  '"You wouldn’t have won if we’d beaten you." ~ Yogi Berra',
  '"When you come to a fork in the road, take it." ~ Yogi Berra',
  '"In baseball, you don’t know nothing." ~ Yogi Berra',
  '"There\'s no crying in baseball!" ~ Jimmy Dugan, A League of Their Own',
  '"All I know is when we win a game, it\'s team win. When we lose a game, it\'s a team loss." ~ Coach Morris Buttermaker, The Bad News Bears',
  '"Legends never die." ~ The Babe, The Sandlot',
  '"How can you not get romantic about baseball?" ~ Billy Beane, Moneyball',
  '"You know what we get to do today, Brooks? We get to play baseball." ~ Jimmy Morris, The Rookie',
];

$output = array_rand(array_flip($baseballisms), 1);
$output = explode(' ~ ', $output);

?>
<div class="main-wrapper">

  <section class="tagbar">
    <div class="container">
      <div class="row">
        <div class="col">35 baseball teams</div>
        <div class="col text-end">25 softball teams</div>
      </div>
    </div>
  </section>
  <section class="section-title justify-content-center py-5">
    <span class="shape shape-left bg-tbr-blue"></span>
    <h2 class="text-info"><?= Page::$title ?></h2>
    <span class="shape shape-right bg-tbr-blue"></span>
  </section>
  <section class="content pt-10">
    <div class="container">
      <div class="col-xs-12 col-md-6 offset-md-3">
        <div class="card bg-success card-hover mb-9">
          <div class="card-body text-center px-md-5 px-lg-6 my-2">
            <div class="card-icon-border-large border-success mtn-80">
              <i class="fa fa-quote-left text-success" aria-hidden="true"></i>
            </div>
            <blockquote class="blockquote blockquote-sm mt-2">
              <p class="font-normal mb-5"> <?= $output[0] ?></p>
              <footer class="blockquote-footer text-uppercase text-white"><?= $output[1] ?></footer>
            </blockquote>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

<!-- fixed-footer-->
<?php
  include_once('../_libs/Thaidate/Thaidate.php');
  include_once('../_libs/Thaidate/thaidate-functions.php');
?>

<footer class="footer footer-static footer-light navbar-border">
  <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span
      class="float-md-left d-block d-md-inline-block text-bold-600">Copyright &copy; 2022 <a class="text-bold-600 orange"
        href="https://scgceramics.com/" target="_blank">Siam Sanitary Ware Industry Co., Ltd.</a>,</span><span
      class="float-md-right d-block d-md-inline-blockd-none d-lg-block text-bold-600">
      <? echo thaidate('วันlที่ j F พ.ศ. Y '); //ผลลัพธ์ วันพฤหัสบดีที่ 12 พฤศจิกายน พ.ศ.2558 เวลา18:55:29 ?><i
        class="ft-heart pink"></i>
    </span></p>
</footer>
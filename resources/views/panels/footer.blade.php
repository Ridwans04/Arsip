<!-- BEGIN: Footer-->
<footer class="footer footer-light {{($configData['footerType'] === 'footer-hidden') ? 'd-none':''}} {{$configData['footerType']}}">
  <p class="clearfix mb-0">
    <span class="float-md-start d-block d-md-inline-block mt-25">Dibuat Pada &copy;
      {{-- <script>document.write(new Date().getDay())</script> -  --}}
      {{-- <script>document.write(new Date().getMonth())</script> - --}}
      <script>document.write(new Date().getFullYear())</script>
     
    </span>
    <span class="float-md-end d-none d-md-block">Perguruan Islam Raudlatul Jannah<i data-feather="trello"></i></span>
  </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->

<!DOCTYPE html>
<html lang="en">

@include('company.partials.header')

<body id="body">

    <!--==========================
    Top Bar
  ============================-->

    @include('company.partials.topbar')

    <!--==========================
    Header
  ============================-->

    @include('company.partials.menubar')

    <!-- #header -->

    <!--==========================
    Intro Section
  ============================-->
    @include('company.partials.jumbotron')
    <!-- #intro -->

    <main id="main">

        <!--==========================
      About Section
    ============================-->
        @include('company.partials.about')
        <!-- #about -->


        <!--==========================
      Our Portfolio Section
    ============================-->
        @include('company.partials.product')


        <!--==========================
      Contact Section
    ============================-->
        @include('company.partials.contacts')
        <!-- #contact -->

    </main>

    <!--==========================
    Footer
  ============================-->

    @include('company.partials.footer')
    <!-- #footer -->


    @include('company.partials.scripts')

</body>

</html>

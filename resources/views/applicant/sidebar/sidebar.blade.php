@extends('applicant.index');

<nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand">FEU Diliman</a>
        <form class="d-flex">
        <a href="{{ route('logout') }}">Logout</a> <!--cinacall niya yung sa authcontrller-->
        </form>
    </div>
</nav>
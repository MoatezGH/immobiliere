@extends('layouts.app')
@section('pageTitle')
Contact nous
@endsection
@section('content')


<div class="contact-area py-120">
    <div class="container">
        <div class="contact-wrapper">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-content">
                        <div class="contact-info">
                            <div class="contact-info-icon">
                                <i class="fal fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>Siège Social</h5>
                                <p>Immeuble Carrefour Bureau N°1-3 Bloc B Avenue Abou Dhabi Hammamet</p>
                            </div>
                        </div>
                        <div class="contact-info">
                            <div class="contact-info-icon">
                                <i class="fal fa-phone"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>Appelez-nous</h5>
                                <p>+216 95 631 100</p>
                            </div>
                        </div>
                        <div class="contact-info">
                            <div class="contact-info-icon">
                                <i class="fal fa-envelope"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>Email</h5>
                                <p>contact@immobiliere.tn</p>
                            </div>
                        </div>
                        <div class="contact-info">
                            <div class="contact-info-icon">
                                <i class="fal fa-clock"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>Horaires de travail</h5>
                                <p>Lun - Sam (08h00 - 17h00)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 align-self-center">
                    <div class="contact-form">
                        <div class="contact-form-header">
                            <h2>Contactez-nous</h2>
                            <br>
                            <br>
                            <br>
                            {{-- <p>It is a long established fact that a reader will be distracted by the readable
                                content of a page randomised words which don't look even slightly when looking at its layout. </p> --}}
                        </div>
                        <form method="post" action="#" id="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Votre Nom" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Votre Email" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" placeholder="Sujet" required="">
                            </div>
                            <div class="form-group">
                                <textarea name="message" cols="30" rows="5" class="form-control" placeholder="Écrivez votre message"></textarea>
                            </div>
                            <button type="submit" class="theme-btn">Send
                                Message <i class="far fa-paper-plane"></i></button>
                            <div class="col-md-12 mt-3">
                                <div class="form-messege text-success"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('panel.layout.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="dashboard-section-area ">
        <div class="container-fluid">
            <h1 class="choose-template-heading">
                Choose a template to start your quote
            </h1>
            <div class="top-filters-area">
                <h6>1 template selected</h6>
                <div class="template-filter">
                    <p>New build</p>
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div>
            <div class="row">
            <aside class="col-md-12">
                    <div class="choose-template-left">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Home</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                    type="button" role="tab" aria-controls="contact"
                                    aria-selected="false">Contact</button>
                            </li>
                            <li>
                            <button type="button" variant="unset" class="blank-quote-btn"><i class="fa fa-plus"
                                aria-hidden="true"></i> Blank quote</button>
                            </li>
                        </ul>
                  
                    </div>

                </aside>
            </div>
            <div class="row">col-md-10
                <aside class="col-md-12">
                    <div class="choose-template-right">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <aside class="col-md-6">
                                <div class="tab-content-area active">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="/var/www/html/renovatorz.biz/resources/views/panel/quotations/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                            </aside>
                            <aside class="col-md-6">
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                                <div class="tab-content-area">
                                    <div class="tab-inner-content-left">
                                        <img src="./images/building.jpg" />
                                        <div class="tab-inner-content">
                                            <h6>New bulid</h6>
                                            <p>Lorem Ipsum is simply dummy text of the printing.</p>
                                        </div>
                                    </div>
                                    <div class="tab-inner-content-right">
                                        <h6>$292k</h6>
                                        <p>38 categories 329tasks</p>
                                    </div>
                                </div>
                            </aside>
                        </div>
                                
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...
                            </div>
                        </div>
                    </div>
                </aside>
                <button class="create-quote">Confirm & Create Quote</button>
            </div>

        </div>
    </section>
</body>
</html>
@endsection

<script src="/var/www/html/renovatorz.biz/public/assets/css/magic-ai.css"></script>


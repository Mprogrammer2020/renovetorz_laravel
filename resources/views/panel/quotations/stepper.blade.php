@extends('panel.layout.app')
@section('content')
<!doctype html>
<html lang="en">


<body>

    <section class="dashboard-section-area ">
        <div class="container-fluid">
            <!-- MultiStep Form -->
            <div class="row stepper-area">
                <div class="col-md-6">
                    <ul id="progressbar">
                        <li class="active">Edit</li>
                        <li>Add Details</li>
                        <li>Send</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <form id="msform">
                        <!-- progressbar -->

                        <!-- fieldsets -->
                        <fieldset>
                            <h2 class="fs-title">Quote #1</h2>
                            <h3 class="fs-subtitle">Click here to add a short description</h3>
                            <ul class="info-area">
                                <li><i class="fa fa-user" aria-hidden="true"></i> test client</li>
                                <li><i class="fa fa-map-marker" aria-hidden="true"></i> 14522 US-98, Magnolia Springs,
                                    AL 36555</li>
                                <li><i class="fa fa-envelope" aria-hidden="true"></i> test@yopmail.com</li>
                                <li><i class="fa fa-phone" aria-hidden="true"></i> 9887766888</li>
                            </ul>
                            <div class="row mt-4">
                                <aside class="col-md-8">
                                    <div class="stepper-inner-content">
                                        <ul>
                                            <li><i class="fa fa-plus" aria-hidden="true"></i> Add a category</li>
                                            <li data-bs-toggle="modal" data-bs-target="#exampleModal">Save as new
                                                template</li>
                                            <li><i class="fa fa-usd" aria-hidden="true"></i> Request prices <i
                                                    class="fa fa-info-circle" aria-hidden="true"></i></li>
                                        </ul>
                                        <h6>Expand all</h6>
                                    </div>
                                    <div class="accordion-area">
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                                        General conditions
                                                    </button>
                                                    <div class="accordion-ara-right">
                                                        <h5>$7,846.20</h5>
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </div>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingOne"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">TASK</th>
                                                                    <th scope="col">QUANTITY</th>
                                                                    <th scope="col">UNIT COST</th>
                                                                    <th scope="col">COST TYPE</th>
                                                                    <th scope="col">MARKUP</th>
                                                                    <th scope="col">TOTAL</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Allowance time for a Project Manager
                                                                    </th>
                                                                    <td>1 Unit</td>
                                                                    <td>$5,769.2</td>
                                                                    <td>Material + Labor</td>
                                                                    <td>0%</td>
                                                                    <td>$5,769.2</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">General admin fees</th>
                                                                    <td>1 Unit</td>
                                                                    <td>$5,769.2</td>
                                                                    <td>Material + Labor</td>
                                                                    <td>0%</td>
                                                                    <td>$5,769.2</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Plans Printing Allowance</th>
                                                                    <td>1 Unit</td>
                                                                    <td>$5,769.2</td>
                                                                    <td>Material + Labor</td>
                                                                    <td>0%</td>
                                                                    <td>$5,769.2</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                        aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        Mobilization
                                                    </button>
                                                    <div class="accordion-ara-right">
                                                        <h5>$7,846.20</h5>
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </div>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingTwo"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion,
                                                        which is intended to demonstrate the
                                                        <code>.accordion-flush</code> class. This is the second item's
                                                        accordion body. Let's imagine this being filled with some actual
                                                        content.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingThree">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                        aria-expanded="false" aria-controls="flush-collapseThree">
                                                        Plans and Permitting
                                                    </button>
                                                    <div class="accordion-ara-right">
                                                        <h5>$7,846.20</h5>
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </div>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingThree"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion,
                                                        which is intended to demonstrate the
                                                        <code>.accordion-flush</code> class. This is the third item's
                                                        accordion body. Nothing more exciting happening here in terms of
                                                        content, but just filling up the space to make it look, at least
                                                        at first glance, a bit more representative of how this would
                                                        look in a real-world application.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingFour">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseFour"
                                                        aria-expanded="false" aria-controls="flush-collapseFour">
                                                        Management Fee
                                                    </button>
                                                    <div class="accordion-ara-right">
                                                        <h5>$7,846.20</h5>
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </div>
                                                </h2>
                                                <div id="flush-collapseFour" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingFour"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion,
                                                        which is intended to demonstrate the
                                                        <code>.accordion-flush</code> class. This is the third item's
                                                        accordion body. Nothing more exciting happening here in terms of
                                                        content, but just filling up the space to make it look, at least
                                                        at first glance, a bit more representative of how this would
                                                        look in a real-world application.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingFive">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseFive"
                                                        aria-expanded="false" aria-controls="flush-collapseFive">
                                                        Demolition
                                                    </button>
                                                    <div class="accordion-ara-right">
                                                        <h5>$7,846.20</h5>
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </div>
                                                </h2>
                                                <div id="flush-collapseFive" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingFive"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion,
                                                        which is intended to demonstrate the
                                                        <code>.accordion-flush</code> class. This is the third item's
                                                        accordion body. Nothing more exciting happening here in terms of
                                                        content, but just filling up the space to make it look, at least
                                                        at first glance, a bit more representative of how this would
                                                        look in a real-world application.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </aside>
                                <aside class="col-md-4">
                                    <div class="stepper-inner-content-right">
                                        <div class="right-area-top">
                                            <div class="right-area-top-right">
                                                <p>Markup on quote</p>
                                                <h6>Edit markup %</h6>
                                            </div>
                                            <div class="right-area-top-left">
                                                <p>$0</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="right-area-top total-area">
                                            <div class="right-area-top-right">
                                                <p>Subtotal</p>
                                            </div>
                                            <div class="right-area-top-left">
                                                <p>$0.00</p>
                                            </div>
                                        </div>
                                        <div class="right-area-top">
                                            <div class="right-area-top-right">
                                                <p>SALES TAXES 6%</p>
                                            </div>
                                            <div class="right-area-top-left">
                                                <p>$0.00</p>
                                            </div>
                                        </div>
                                        <div class="right-area-top">
                                            <div class="right-area-top-right">
                                                <h6>Edit taxes</h6>
                                            </div>

                                        </div>
                                        <div class="right-area-top total-area">
                                            <div class="right-area-top-right">
                                                <p>Total</p>
                                            </div>
                                            <div class="right-area-top-left">
                                                <p>$0.00</p>
                                            </div>
                                        </div>
                                        <button type="button" variant="unset">Add Conditions and Send</button>
                                        <h3><i class="fa fa-eye" aria-hidden="true"></i>Client Preview-PDF</h3>
                                    </div>
                                </aside>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Next" />
                        </fieldset>
                        <fieldset>
                            <h2 class="fs-title">Social Profiles</h2>
                            <h3 class="fs-subtitle">Your presence on the social network</h3>
                            <input type="text" name="twitter" placeholder="Twitter" />
                            <input type="text" name="facebook" placeholder="Facebook" />
                            <input type="text" name="gplus" placeholder="Google Plus" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                            <input type="button" name="next" class="next action-button" value="Next" />
                        </fieldset>
                        <fieldset>
                            <h2 class="fs-title">Create your account</h2>
                            <h3 class="fs-subtitle">Fill in your credentials</h3>
                            <input type="text" name="email" placeholder="Email" />
                            <input type="password" name="pass" placeholder="Password" />
                            <input type="password" name="cpass" placeholder="Confirm Password" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                            <input type="submit" name="submit" class="submit action-button" value="Submit" />
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- /.MultiStep Form -->
        </div>
    </section>


    <div class="modal fade save-template-area" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Save as New Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Template Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary confirm-btn">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script>

        //jQuery time
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches

        $(".next").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({ opacity: 0 }, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = (now * 50) + "%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'position': 'absolute'
                    });
                    next_fs.css({ 'left': left, 'opacity': opacity });
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".previous").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();
            //hide the current fieldset with style
            current_fs.animate({ opacity: 0 }, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1 - now) * 50) + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({ 'left': left });
                    previous_fs.css({ 'transform': 'scale(' + scale + ')', 'opacity': opacity });
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".submit").click(function () {
            return false;
        })
    </script>
</body>

</html>
@endsection
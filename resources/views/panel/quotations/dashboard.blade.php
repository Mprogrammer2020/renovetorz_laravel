@extends('panel.layout.app')
@section('content')
<!doctype html>
<html lang="en">

<body>
	<!-- dashboard section starts-->
	<section class="dashboard-section-area">
		<div class="container">
			<div class="row">
				<aside class="col-md-8">
					<div class="matching-area">
						<div class="row">
							<aside class="col-md-4">
								<div class="matching-inner-box">
									<div class="icon-box">
										<i class="fa fa-usd" aria-hidden="true"></i>
									</div>
									<div class="matching-content">
										<p>Matching jobs</p>
										<h3>1.450</h3>
									</div>
								</div>
							</aside>
							<aside class="col-md-4">
								<div class="matching-inner-box">
									<div class="icon-box">
										<i class="fa fa-user-o" aria-hidden="true"></i>
									</div>
									<div class="matching-content">
										<p>Matching jobs</p>
										<h3>1.450</h3>
									</div>
								</div>
							</aside>
							<aside class="col-md-4">
								<div class="matching-inner-box">
									<div class="icon-box">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</div>
									<div class="matching-content">
										<p>Matching jobs</p>
										<h3>1.450</h3>
									</div>
								</div>
							</aside>
						</div>
					</div>
					<div class="matching-graphs">
						<div class="row">
							<aside class="col-md-8">
								<div class="matching-inner">
									<h4>Opportunities</h4>
									<!-- gaphs here add-->
								</div>
							</aside>
							<aside class="col-md-4">
								<div class="lead-inner">
									<h3>Lead Setting</h3>
									<div class="service-lead">
										<div class="inner-service-lead">
											<h5>Services</h5>
											<a href="#">Edit</a>
										</div>
										<p>You'll receieve leads in these categories.</p>
										<span>Social media Marketing</span>
										<span>Email Marketing</span>
										<span>+6</span>
									</div>
									<div class="service-lead">
										<div class="inner-service-lead">
											<h5>Locations</h5>
											<a href="#">Edit</a>
										</div>
										<p>You'll receieve customers within</p>
										<p><i class="fa fa-map-marker" aria-hidden="true"></i> Nationwide
										</p>
										<p><i class="fa fa-map-marker" aria-hidden="true"></i> Nationwide
										</p>
										<a href="#">See More</a>
									</div>
								</div>
							</aside>
						</div>
					</div>
				</aside>
				<aside class="col-md-4">
					<div class="profile-outer-box">
						<img src="images/admin.png" alt="admin" />
						<h5 class="my-3">Gary B</h5>
					</div>
					<div class="service-lead">
						<div class="inner-service-lead">
							<h6>Your profile is 87% complete</h6>
							<a href="#">Edit</a>
						</div>
						<div class="progress mt-2">
							<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
								aria-valuemax="100"></div>
						</div>
					</div>
					<div class="lead-inner">
						<h3>Your Account</h3>
						<div class="inner-service-lead">
							<p><i class="fa fa-user" aria-hidden="true"></i> Standard
							</p>
							<a href="#">Upgrade to Elite Pro</a>
						</div>
						<div class="inner-service-lead">
							<p><i class="fa fa-user" aria-hidden="true"></i> 83 Credits
							</p>
							<a href="#">Manage</a>
						</div>
					</div>
				</aside>
			</div>
			<div class="row">
				<aside class="col-md-6">
					<div class="table-top-box mb-2">
						<table class="table">
							<tbody>
								<tr>
									<td scope="row">About 5 response</td>
									<td>60 credits</td>
									<td>$141.00</td>
									<td><button class="credit-btn">
											Buy Credts
										</button></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-top-box mb-2">
						<table class="table">
							<tbody>
								<tr>
									<td scope="row">About 5 response</td>
									<td>60 credits</td>
									<td>$141.00</td>
									<td><button class="credit-btn">
											Buy Credts
										</button></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-top-box">
						<table class="table">
							<tbody>
								<tr>
									<td scope="row">About 5 response</td>
									<td>60 credits</td>
									<td>$141.00</td>
									<td><button class="credit-btn">
											Buy Credts
										</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</aside>
				<aside class="col-md-6">
					<div class="table-top-box mb-2">
						<table class="table">
							<tbody>
								<tr>
									<th>Description</th>
									<th>Credit</th>
									<th>Date</th>
								</tr>
								<tr>
									<td>21 credit used to reply to customer</td>
									<td>-21</td>
									<td>Oct 12, 2023</td>
								</tr>
								<tr>
									<td>21 credit used to reply to customer</td>
									<td>-21</td>
									<td>Oct 12, 2023</td>
								</tr>
								<tr>
									<td>21 credit used to reply to customer</td>
									<td>-21</td>
									<td>Oct 12, 2023</td>
								</tr>
								<tr>
									<td>21 credit used to reply to customer</td>
									<td>-21</td>
									<td>Oct 12, 2023</td>
								</tr>
								<tr>
									<td>21 credit used to reply to customer</td>
									<td>-21</td>
									<td>Oct 12, 2023</td>
								</tr>
								<tr>
									<td>21 credit used to reply to customer</td>
									<td>-21</td>
									<td>Oct 12, 2023</td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</aside>
			</div>
		</div>
	</section>
	<!-- dashboard section ends-->

</body>

</html>
@endsection
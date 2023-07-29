@extends('admin.layouts.app')
@section('content')
@include('admin.layouts.navbars.navbar')
	<div class="container-fluid py-4">
		<div class="">
			<div class="row mb-4">
				<div class="col mb-4">
					<div class="card">
						<div class="card-header pb-0">
							<div class="d-flex justify-content-between">
								<div class="">
									<h4>Thống kê</h4>
								</div>
								<div class="">
									<div class="dropdown">
										<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											{{ App\Enums\HomeEnums::FILTER[$filterType] }}
										</a>
										<ul class="dropdown-menu dropdown-menu-end">
											@foreach(App\Enums\HomeEnums::FILTER as $key=>$value)
												<li>
													<a 
														class="dropdown-item fw-bold text-center" 
														href="{{ route('dashboard', ['filter_type' => $key]) }}"
													>
														{{ $value }}
													</a>
												</li>
											@endforeach
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body px-0 px-4">
							<div class="row mt-4">
								<div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
									<div class="px-2 py-3 flex-fill">
										<div class="card ">
											<div class="card-header p-3 pt-2">
												<div class="icon icon-lg icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
													<i class="fas fa-book"></i>
												</div>
												<div class="text-end pt-1">
													<p class="text-sm mb-0 text-capitalize fw-bold">Lượt mượn sách</p>
													<h4 class="mb-0">{{ isset($newBorrowerStatistic) ? $newBorrowerStatistic : '0' }}</h4>
												</div>
											</div>
											<hr class="dark horizontal my-0">
											<div class="card-footer p-3">
												<p class="mb-0 fw-bold text-secondary opacity-7">
													<span class="text-success text-sm font-weight-bolder">	
														@if (!empty($newBorrowerStatistic) && !empty($newBorrowerStatisticOld))
															{{ number_format(
																( 
																	isset($newBorrowerStatistic) ? $newBorrowerStatistic * 100 : 0
																)/$newBorrowerStatisticOld, 1) 
															}} % 
														@else
															0.0 %
														@endif
													</span> so với {{ App\Enums\HomeEnums::FILTER[$filterType] }} trước
												</p>
											</div>
										</div>
									</div>
									<div class="px-2 py-3 flex-fill">
										<div class="card">
											<div class="card-header p-3 pt-2">
												<div class="icon icon-lg icon-shape bg-gradient-warning shadow-dark text-center border-radius-xl mt-n4 position-absolute">
													<i class="fas fa-book"></i>
												</div>
												<div class="text-end pt-1">
													<p class="text-sm mb-0 text-capitalize fw-bold">Lượt trả sách</p>
													<h4 class="mb-0">{{ isset($borrowerStatistic[App\Enums\BorrowerEnums::STATUS_INACTIVE]) ? $borrowerStatistic[App\Enums\BorrowerEnums::STATUS_INACTIVE] : '0' }}</h4>
												</div>
											</div>
											<hr class="dark horizontal my-0">
											<div class="card-footer p-3">
												<p class="mb-0 fw-bold text-secondary opacity-7">
													<span class="text-success text-sm font-weight-bolder">
														@if (!empty($borrowerStatisticOld[App\Enums\BorrowerEnums::STATUS_INACTIVE]) && !empty($borrowerStatistic[App\Enums\BorrowerEnums::STATUS_INACTIVE]))
															{{ number_format(
																( 
																	isset($borrowerStatistic[App\Enums\BorrowerEnums::STATUS_INACTIVE]) ? $borrowerStatistic[App\Enums\BorrowerEnums::STATUS_INACTIVE] * 100 : 0
																)/$borrowerStatisticOld[App\Enums\BorrowerEnums::STATUS_INACTIVE], 1) 
															}} % 
														@else
															0.0 %
														@endif
													</span> so với {{ App\Enums\HomeEnums::FILTER[$filterType] }} trước
												</p>
											</div>
										</div>
									</div>
									<div class="px-2 py-3 flex-fill">
										<div class="card">
											<div class="card-header p-3 pt-2">
												<div class="icon icon-lg icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">
													<i class="fas fa-book"></i>
												</div>
												<div class="text-end pt-1">
													<p class="text-sm mb-0 text-capitalize fw-bold">Lượt gia hạn sách</p>
													<h4 class="mb-0">{{ isset($borrowerStatistic[App\Enums\BorrowerEnums::STATUS_EXTEND]) ? $borrowerStatistic[App\Enums\BorrowerEnums::STATUS_EXTEND] : '0' }}</h4>
												</div>
											</div>
											<hr class="dark horizontal my-0">
											<div class="card-footer p-3">
												<p class="mb-0 fw-bold text-secondary opacity-7">
													<span class="text-success text-sm font-weight-bolder">	
														@if (!empty($borrowerStatisticOld[App\Enums\BorrowerEnums::STATUS_EXTEND]) && !empty($borrowerStatistic[App\Enums\BorrowerEnums::STATUS_EXTEND]))
															{{ number_format(
																( 
																	isset($borrowerStatistic[App\Enums\BorrowerEnums::STATUS_EXTEND]) ? $borrowerStatistic[App\Enums\BorrowerEnums::STATUS_EXTEND] * 100 : 0
																)/$borrowerStatisticOld[App\Enums\BorrowerEnums::STATUS_EXTEND], 1) 
															}} %
														@else 
															0.0 %
														@endif
													</span> so với {{ App\Enums\HomeEnums::FILTER[$filterType] }} trước
												</p>
											</div>
										</div>
									</div>
									<div class="px-2 py-3 flex-fill">
										<div class="card">
											<div class="card-header p-3 pt-2">
												<div class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
													<i class="fas fa-book"></i>
												</div>
												<div class="text-end pt-1">
													<p class="text-sm mb-0 text-capitalize fw-bold">Sách mới</p>
													<h4 class="mb-0">{{ isset($booksStatistic) ? $booksStatistic : '0' }}</h4>
												</div>
											</div>
											<hr class="dark horizontal my-0">
											<div class="card-footer p-3">
												<p class="mb-0 fw-bold text-secondary opacity-7">
													<span class="text-success text-sm font-weight-bolder">	
														@if (!empty($booksStatisticOld))
															@if ($booksStatistic > $booksStatisticOld)
																+ 
															@endif
															{{ number_format(($booksStatistic * 100 )/$booksStatisticOld, 1) }} % 
														@else 
															0.0 %
														@endif
													</span> so với {{ App\Enums\HomeEnums::FILTER[$filterType] }} trước
												</p>
											</div>
										</div>
									</div>
									<div class="px-2 py-3 flex-fill">
										<div class="card">
											<div class="card-header p-3 pt-2">
												<div class="icon icon-lg icon-shape bg-gradient-danger shadow-dark text-center border-radius-xl mt-n4 position-absolute">
													<i class="fas fa-users" aria-hidden="true"></i>
												</div>
												<div class="text-end pt-1">
													<p class="text-sm mb-0 text-capitalize fw-bold">Người dùng mới</p>
													<h4 class="mb-0">{{ isset($usersStatistic) ? $usersStatistic : '0' }}</h4>
												</div>
											</div>
											<hr class="dark horizontal my-0">
											<div class="card-footer p-3">
												<p class="mb-0 fw-bold text-secondary opacity-7">
													<span class="text-success text-sm font-weight-bolder">	
														@if (!empty($usersStatisticOld))
															@if ($usersStatistic > $usersStatisticOld)
																+
															@endif
															{{ number_format(($usersStatistic * 100 )/$usersStatisticOld, 1) }} % 
														@else 
														0.0 %
														@endif
													</span> so với {{ App\Enums\HomeEnums::FILTER[$filterType] }} trước
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="">
			<div class="row mb-4">
				<div class="col-lg-6 mb-4">
					<div class="card">
						<div class="card-header pb-0">
							<div class="row">
								<div class="col-lg-6 col-7">
									<h4>Top tặng sách</h4>
								</div>
							</div>
						</div>
						@if(count($topUsers) == 0)
							<div class="align-items-center text-center fw-bold py-3 min-height-100 opacity-7">
								<h4>Không có dữ liệu</h4>
							</div>
						@else
							<div class="card-body px-0 pb-2">
								<div class="table-responsive">
									<table class="table align-items-center mb-0 min-height-100">
										<thead>
											<tr>
												<th class="text-uppercase text-sm font-weight-bolder ">#</th>
												<th class="text-uppercase text-sm font-weight-bolder ">Họ tên</th>
												<th class="text-center text-uppercase text-sm font-weight-bolder  ps-2">Số lượt Tặng mới </th>
												<th class="text-center text-uppercase text-sm font-weight-bolder ">Tổng số sách tặng mới</th>
												<th class="text-center text-uppercase text-sm font-weight-bolder ">Tổng số sách tặng</th>
											</tr>
										</thead>
										<tbody>
											@foreach($topUsers as $key=>$user)
												<tr>
													<td class="text-left ps-4 fw-bold text-secondary opacity-7">
														{{ $key + 1 }}
													</td>
													<td class="text-left ps-4 fw-bold text-secondary opacity-7">
														{{ $user['name'] }}
													</td>
													<td class="text-center fw-bold text-secondary opacity-7">
														{{ $user['totalTimesByBetween'] }}
													</td>
													<td class="text-center fw-bold text-secondary opacity-7">
														{{ $user['totalQuantityByBetween'] }}
													</td>
													<td class="text-center fw-bold text-secondary opacity-7">
														{{ $user['totalQuantity'] }}
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif
					</div>
				</div>

				
				<div class="col-lg-6 mb-4">
					<div class="card">
						<div class="card-header pb-0">
							<div class="row">
								<div class="col-lg-6 ">
									<h4>Top sách mượn</h4>
								</div>
							</div>
						</div>
						@if(count($topBooks) == 0)
							<div class="align-items-center text-center fw-bold py-3 min-height-100 opacity-7">
								<h4>Không có dữ liệu</h4>
							</div>
						@else
							<div class="card-body px-0 pb-2">
								<div class="table-responsive">
									<table class="table align-items-center mb-0 min-height-100">
										<thead>
											<tr>
												<th class="text-uppercase text-sm font-weight-bolder ">#</th>
												<th class="text-uppercase text-sm font-weight-bolder ">Tên sách</th>
												<th class="text-center text-uppercase text-sm font-weight-bolder  ps-2">Số lượt mượn mới</th>
												<th class="text-center text-uppercase text-sm font-weight-bolder ">%</th>
												<th class="text-center text-uppercase text-sm font-weight-bolder ">Tổng số lượt mượn sách</th>
											</tr>
										</thead>
										<tbody>
											@foreach($topBooks as $key=>$book)
												<tr>
													<td class="text-left ps-4 fw-bold text-secondary opacity-7">
														{{ $key + 1 }}
													</td>
													<td class="text-left ps-4 fw-bold text-secondary opacity-7">
														{{ $book['name'] }}
													</td>
													<td class="text-center fw-bold text-secondary opacity-7">
														{{ $book['totalByBetween'] }}
													</td>
													<td class="text-center fw-bold text-secondary opacity-7">
														{{ number_format($book['totalByBetween']/$book['totalQuantity'], 1) }}
													</td>
													<td class="text-center fw-bold text-secondary opacity-7">
														{{ $book['totalQuantity'] }}
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
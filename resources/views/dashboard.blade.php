@extends('layouts.layout')
@section('content')
<section class="section dashboard">
    <div class="row">
      <div class="col-12">
        <div class="row">
          <!-- Users Card -->
          <div class="col-xxl-2 col-xl-12">
            <div class="card info-card customers-card">
              {{-- <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div> --}}
              <div class="card-body">
                <h5 class="card-title">Users <span></span></h5>
                <div class="d-flex align-items-center">
                  <a href="#" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </a>
                  <div class="ps-3">
                    <h6>{{$users}}</h6>
                    {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Users Card -->
          <!-- Books Card -->
          <div class="col-xxl-2 col-md-6">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">Brands <span></span></h5>
                <div class="d-flex align-items-center">
                  <a href="#" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-layer-group"></i>
                  </a>
                  <div class="ps-3">
                    <h6>{{ $brands }}</h6>
                    {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Books Card -->
  
          <!-- Videos Card -->
          <div class="col-xxl-2 col-md-6">
            <div class="card info-card revenue-card">
  
    
              <div class="card-body">
                <h5 class="card-title">Categories <span></span></h5>
  
                <div class="d-flex align-items-center">
                  <a href="#" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-list"></i>
                  </a>
                  <div class="ps-3">
                    <h6>{{ $categories }}</h6>
                    {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
  
                  </div>
                </div>
              </div>
  
            </div>
          </div>
          <!-- End Videos Card -->
  
          <!-- Audios Card -->
          <div class="col-xxl-2 col-md-6">
            <div class="card info-card revenue-card">
  
  
              <div class="card-body">
                <h5 class="card-title">Products <span></span></h5>
  
                <div class="d-flex align-items-center">
                  <a href="#" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fa-brands fa-product-hunt"></i>
                  </a>
                  <div class="ps-3">
                    <h6>{{ $products }}</h6>
                    {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
  
                  </div>
                </div>
              </div>
  
            </div>
          </div>
          <!-- End Audios Card -->
              
          <!-- Quotes Card -->
          <div class="col-xxl-2 col-md-6">
            <div class="card info-card sales-card">
  
           
  
              <div class="card-body">
                <h5 class="card-title">Orders <span></span></h5>
  
                <div class="d-flex align-items-center">
                  <a href="#" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                  </a>
                  <div class="ps-3">
                    <h6>{{ $orders }}</h6>
                    {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
  
                  </div>
                </div>
              </div>
  
            </div>
          </div>
          <!-- End Quotes Card -->
  
          
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">
          <!-- Reports -->
          <div class="col-12">
            <div class="card">
  
            
  
              <div class="card-body">
                <h5 class="card-title">Reports <span></span></h5>
                <input type="hidden" id="monthlyUser" value='{{ json_encode($monthwise_array)}}'>
                <input type="hidden" id="monthlySubscription" value='{{ json_encode($monthwise_array_order) }}'>
                <!-- Line Chart -->
                <div id="reportsChart"></div>
  
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      
                    var randomScalingFactor = function(MONTH,Income='No') {
                      var monthOrder =  JSON.parse($("#monthlyUser").val());
                      if(typeof  monthOrder[MONTH]  !== 'undefined'){
                        return Math.round(monthOrder[MONTH].total_user);
                      }else{           
                        return Math.round(0);
                      }
                    };
                    var randomScalingFactor1 = function(MONTH,Income='No') {
                      var monthOrder =  JSON.parse($("#monthlySubscription").val());
                      if(typeof  monthOrder[MONTH]  !== 'undefined'){
                        return Math.round(monthOrder[MONTH].total_user);
                      }else{           
                        return Math.round(0);
                      }
                    };
                    new ApexCharts(document.querySelector("#reportsChart"), {
                      series: [{
                        name: 'Users',
                        data: [
                              randomScalingFactor('1'),
                              randomScalingFactor('2'),
                              randomScalingFactor('3'),
                              randomScalingFactor('4'),
                              randomScalingFactor('5'),
                              randomScalingFactor('6'),
                              randomScalingFactor('7'),
                              randomScalingFactor('8'),
                              randomScalingFactor('9'),
                              randomScalingFactor('10'),
                              randomScalingFactor('11'),
                              randomScalingFactor('12')
                          ],
                      }, 
                      {
                        name: 'Orders',
                        data: [
                              randomScalingFactor1('1'),
                              randomScalingFactor1('2'),
                              randomScalingFactor1('3'),
                              randomScalingFactor1('4'),
                              randomScalingFactor1('5'),
                              randomScalingFactor1('6'),
                              randomScalingFactor1('7'),
                              randomScalingFactor1('8'),
                              randomScalingFactor1('9'),
                              randomScalingFactor1('10'),
                              randomScalingFactor1('11'),
                              randomScalingFactor1('12')
                          ],
                      }, 
                      //{
                      //   name: 'Customers',
                      //   data: [15, 11, 32, 18, 9, 24, 11]
                      // }
                    ],
                      chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                          show: false
                        },
                      },
                      markers: {
                        size: 4
                      },
                      colors: ['#4154f1', '#2eca6a', '#ff771d'],
                      fill: {
                        type: "gradient",
                        gradient: {
                          shadeIntensity: 1,
                          opacityFrom: 0.3,
                          opacityTo: 0.4,
                          stops: [0, 90, 100]
                        }
                      },
                      dataLabels: {
                        enabled: false
                      },
                      stroke: {
                        curve: 'smooth',
                        width: 2
                      },
                      xaxis: {
                        type: 'date',
                        categories: MONTHS,
                      },
                      tooltip: {
                        x: {
                          format: 'dd/MM/yy HH:mm'
                        },
                      }
                    }).render();
                  });
                </script>
                <!-- End Line Chart -->
  
              </div>
  
            </div>
          </div><!-- End Reports -->
  
         
        </div>
      </div><!-- End Left side columns -->
  
      <!-- Right side columns -->
      <div class="col-lg-4">
  
        <!-- Recent Activity -->
        <div class="card">
         
          <div class="card-body">
            <h5 class="card-title">Recent Activity <span></span></h5>
  
            <div class="activity">
              @foreach ($recently_added  as $key => $new_user)
                
                <div class="activity-item d-flex">
                  <div class="activite-label">{{$new_user->created_at_human}} </div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    {{($new_user->name!='')?$new_user->name:$new_user->email}} <a href="#" class="fw-bold text-dark">Joined </a>
                  </div>
                </div>
                <!-- End activity item-->
              @endforeach
             
            </div>
  
          </div>
        </div><!-- End Recent Activity -->
  
       
        <!-- Website Traffic -->
        {{-- <div class="card">
        
          <div class="card-body pb-0">
            <h5 class="card-title">Overview</h5>
            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                echarts.init(document.querySelector("#trafficChart")).setOption({
                  tooltip: {
                    trigger: 'item'
                  },
                  legend: {
                    top: '5%',
                    left: 'center'
                  },
                  series: [{
                    name: 'Total',
                    type: 'pie',
                    radius: ['40%', '65%'],
                    avoidLabelOverlap: false,
                    label: {
                      show: false,
                      position: 'center'
                    },
                    emphasis: {
                      label: {
                        show: true,
                        fontSize: '18',
                        fontWeight: 'bold'
                      }
                    },
                    labelLine: {
                      show: false
                    },
                    data: [{
                        value: {{json_encode(0)}},
                        name: 'Videos'
                      },
                    ]
                  }]
                });
              });
            </script>
          </div>
        </div> --}}
        <!-- End Website Traffic -->
  
         {{-- <!-- Budget Report -->
         <div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filter</h6>
              </li>
              <li><a class="dropdown-item" href="#">Today</a></li>
              <li><a class="dropdown-item" href="#">This Month</a></li>
              <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
          </div>
          <div class="card-body pb-0">
            <h5 class="card-title">Budget Report <span>| This Month</span></h5>
            <div id="budgetChart" style="min-height: 400px;" class="echart"></div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                  legend: {
                    data: ['Allocated Budget', 'Actual Spending']
                  },
                  radar: {
                    // shape: 'circle',
                    indicator: [{
                        name: 'Sales',
                        max: 6500
                      },
                      {
                        name: 'Administration',
                        max: 16000
                      },
                      {
                        name: 'Information Technology',
                        max: 30000
                      },
                      {
                        name: 'Customer Support',
                        max: 38000
                      },
                      {
                        name: 'Development',
                        max: 52000
                      },
                      {
                        name: 'Marketing',
                        max: 25000
                      }
                    ]
                  },
                  series: [{
                    name: 'Budget vs spending',
                    type: 'radar',
                    data: [{
                        value: [4200, 3000, 20000, 35000, 50000, 18000],
                        name: 'Allocated Budget'
                      },
                      {
                        value: [5000, 14000, 28000, 26000, 42000, 21000],
                        name: 'Actual Spending'
                      }
                    ]
                  }]
                });
              });
            </script>
  
          </div>
        </div><!-- End Budget Report --> --}}
  
        {{-- <!-- News & Updates Traffic -->
        <div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filter</h6>
              </li>
              <li><a class="dropdown-item" href="#">Today</a></li>
              <li><a class="dropdown-item" href="#">This Month</a></li>
              <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
          </div>
          <div class="card-body pb-0">
            <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>
            <div class="news">
              <div class="post-item clearfix">
                <img src="assets/img/news-1.jpg" alt="">
                <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
              </div>
              <div class="post-item clearfix">
                <img src="assets/img/news-2.jpg" alt="">
                <h4><a href="#">Quidem autem et impedit</a></h4>
                <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
              </div>
              <div class="post-item clearfix">
                <img src="assets/img/news-3.jpg" alt="">
                <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
              </div>
              <div class="post-item clearfix">
                <img src="assets/img/news-4.jpg" alt="">
                <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
              </div>
              <div class="post-item clearfix">
                <img src="assets/img/news-5.jpg" alt="">
                <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
              </div>
            </div><!-- End sidebar recent posts-->
          </div>
        </div><!-- End News & Updates --> --}}
      </div><!-- End Right side columns -->
    </div>
  </section>

@endsection
@push('script')
    
@endpush
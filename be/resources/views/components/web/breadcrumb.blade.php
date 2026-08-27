 <div class="row">
   <div class="col-12 col-md-6 order-md-1 order-last">
     <h3>{{ $title }}</h3>
   </div>

   <div class="col-12 col-md-6 order-md-2 order-first">
     <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
       <ol class="breadcrumb">
         <li class="breadcrumb-item">
           <a href="{{ $route }}">{{ $page }}</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">
           {{ $active }}
         </li>
       </ol>
     </nav>
   </div>

 </div>

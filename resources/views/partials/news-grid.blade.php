
 @forelse($news as $item)
     <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6  mb-4">
         <div class="card h-100 shadow-sm">
             <h5 class="card-title p-2 text-center">
                 {{ Str::limit($item->title, 60) }}

             </h5>
             @if($item->image)
                 <a href="{{ route('news.show', $item->id) }}" class="p-2">
                 <img src="{{ $item->image }}" class="card-img-top" style="height:200px;object-fit:cover;" alt="{{ $item->title }}">
                 </a>
             @endif
             <div class="card-body d-flex flex-column">
                 <p class="badge bg-primary mb-2">
                          @foreach($item->categories as $category)
                         <a href="{{ route('category.show', $category->slug) }}" class="cat-title badge bg-primary text-white text-decoration-none me-2 text-uppercase ">
                            <span>Категория:</span>  {{ $category->name }}
                         </a>
                     @endforeach
                 </p>
                 <a href="{{ route('news.show', $item->id) }}" class="btn btn-outline-primary mt-auto">
                     Прочети
                 </a>
             </div>

         </div>
     </div>
 @empty
     <div class="col-12 text-center py-5">
         <p class="text-muted">Няма намерени новини.</p>
     </div>
 @endforelse


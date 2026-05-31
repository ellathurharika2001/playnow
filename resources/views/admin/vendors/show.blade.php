<x-layouts.app.sidebar :title="$title ?? 'Turf Details'">
    <flux:main>
  
        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}"> 
       
        <div class="vendor-detail-view"> 
            <div class="vendor-detail-container">
                <!-- Header -->
                <div class="detail-header">
                    <h1 class="detail-title">Turf Details</h1>
                    <a href="{{ route('admin.vendors') }}" class="back-btn">
                        <i class="bi bi-arrow-left"></i>
                        Back to List
                    </a>
                </div>
                
                <!-- Turf Header Info -->
                <div class="vendor-header-info">
                    <div class="vendor-avatar-lg">
                        {{ substr($vendor->turf_name, 0, 1) }}
                    </div>
                    <div class="vendor-main-info">
                        <h3>{{ $vendor->turf_name }}</h3>
                        <div class="vendor-subtitle">
                            <span><i class="bi bi-person"></i> {{ $vendor->owner_name }}</span>
                            <span><i class="bi bi-envelope"></i> {{ $vendor->email }}</span>
                            <span><i class="bi bi-telephone"></i> {{ $vendor->mobile }}</span>
                            <span><i class="bi bi-trophy"></i> {{ $vendor->sport_type }}</span>                        
                            <span>
                                @if($vendor->status === 'approved')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle-fill"></i> Approved
                                    </span>
                                @elseif($vendor->status === 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock-fill"></i> Pending
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-x-circle-fill"></i> Rejected
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Main Card -->
                <div class="detail-card">
                    
                    <!-- Owner & Contact Section -->
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h2 class="section-title">Owner & Contact</h2>
                    </div>
                    
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Owner Name</div>
                            <div class="detail-value">{{ $vendor->owner_name }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Email Address</div>
                            <div class="detail-value">{{ $vendor->email }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Phone Number</div>
                            <div class="detail-value">{{ $vendor->mobile }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Sport Type</div>
                            <div class="detail-value">{{ $vendor->sport_type }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Registration Date</div>
                            <div class="detail-value">{{ $vendor->created_at->format('F d, Y') ?? 'N/A' }}</div>
                        </div>
                    </div>
                    
                    <!-- Location Details Section -->
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h2 class="section-title">Location Details</h2>
                    </div>
                    
                    <div class="detail-grid">
                        <div class="detail-item full-width">
                            <div class="detail-label">Full Address</div>
                            <div class="detail-value">{{ $vendor->full_address }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Area & City</div>
                            <div class="detail-value">{{ $vendor->area_city }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Landmark</div>
                            <div class="detail-value {{ !$vendor->landmark ? 'empty' : '' }}">
                                {{ $vendor->landmark ?? 'Not Provided' }}
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Google Maps Link</div>
                            <div class="detail-value">
                                @if($vendor->google_maps_link)
                                    <a href="{{ $vendor->google_maps_link }}" target="_blank" class="text-primary">
                                        {{ Str::limit($vendor->google_maps_link, 40) }}
                                    </a>
                                @else
                                    <span class="empty">Not Provided</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pricing & Schedule Section -->
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h2 class="section-title">Pricing & Schedule</h2>
                    </div>
                    
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Turf Size</div>
                            <div class="detail-value">{{ $vendor->turf_size }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Indoor/Outdoor</div>
                            <div class="detail-value">{{ $vendor->indoor_outdoor }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Price per Hour</div>
                            <div class="detail-value">₹ {{ number_format($vendor->price_per_hour, 2) }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Slot Duration</div>
                            <div class="detail-value">{{ $vendor->slot_duration }} minutes</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Opening Time</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($vendor->opening_time)->format('h:i A') }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Closing Time</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($vendor->closing_time)->format('h:i A') }}</div>
                        </div>
                    </div>
                    
                    <!-- Photos Section -->
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="bi bi-images"></i>
                        </div>
                        <h2 class="section-title">Photos</h2>
                    </div>
                    
                    @php
                        $photos = is_string($vendor->photos) ? json_decode($vendor->photos, true) : $vendor->photos;
                    @endphp
                    
                    @if(!empty($photos) && is_array($photos))
                        <div class="photo-gallery" style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px;">
                            @foreach($photos as $photo)
                                <div class="photo-item" style="width: 150px; height: 150px; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;">
                                    <img src="{{ asset($photo) }}" alt="Turf photo" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state" style="padding: 20px; text-align: center; background: #f8f9fa; border-radius: 8px;">
                            <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                            <p class="mt-2">No photos uploaded</p>
                        </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('admin.vendors') }}" class="btn-primary">
                            <i class="bi bi-list-ul"></i>
                            Back to Turf List
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Detect theme and apply appropriate class
                const isDarkTheme = document.documentElement.getAttribute('data-theme') === 'dark' || 
                                    document.body.classList.contains('dark-theme');
                
                const detailView = document.querySelector('.vendor-detail-view');
                if (detailView) {
                    detailView.classList.add(isDarkTheme ? 'dark-theme' : 'light-theme');
                }
                
                // Add animation to detail items on load
                const detailItems = document.querySelectorAll('.detail-item');
                detailItems.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        item.style.transition = 'all 0.4s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, index * 50);
                });
                
                // Copy functionality for sensitive data (optional, can be removed if not needed)
                const sensitiveFields = document.querySelectorAll('.detail-item');
                sensitiveFields.forEach(field => {
                    field.addEventListener('click', function(e) {
                        if (e.target.classList.contains('detail-value') && 
                            !e.target.classList.contains('empty') &&
                            !e.target.querySelector('a')) { // avoid copying links
                            
                            const textToCopy = e.target.textContent;
                            navigator.clipboard.writeText(textToCopy).then(() => {
                                const originalText = e.target.textContent;
                                e.target.textContent = 'Copied!';
                                e.target.style.color = 'var(--accent-color)';
                                
                                setTimeout(() => {
                                    e.target.textContent = originalText;
                                    e.target.style.color = '';
                                }, 1500);
                            }).catch(() => {});
                        }
                    });
                });
            });
        </script>
    </flux:main>
</x-layouts.app.sidebar>
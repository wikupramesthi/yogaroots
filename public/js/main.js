// Mobile nav
const btn = document.getElementById('mobileBtn');
const drawer = document.getElementById('mobileNav');
if (btn && drawer) btn.addEventListener('click', ()=> drawer.classList.toggle('hidden'));

// Navbar scroll effect
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', ()=>{
  if(window.scrollY>10) navbar.classList.add('shadow-sm');
  else navbar.classList.remove('shadow-sm');
});

// Booking modal
window.openBooking = (kelas='')=>{
  const m=document.getElementById('bookingModal');
  if(!m) return;
  m.classList.remove('hidden');
  if(kelas) { const s=m.querySelector('select[name=kelas]'); if(s) s.value=kelas; }
}
window.closeBooking = ()=>{
  document.getElementById('bookingModal')?.classList.add('hidden');
}

// Booking form
document.getElementById('bookingForm')?.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const fd=new FormData(e.target);
  const body=Object.fromEntries(fd.entries());
  const msg=document.getElementById('bookingMsg');
  msg.className='text-sm mt-3 p-3 rounded-xl bg-sage-50';
  msg.textContent='Mengirim...'; msg.classList.remove('hidden');
  try{
    const r=await fetch('/api/booking',{method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(body)});
    const j=await r.json();
    msg.textContent=j.message;
    msg.className='text-sm mt-3 p-3 rounded-xl '+(j.success?'bg-green-50 text-green-700':'bg-red-50 text-red-700');
    if(j.success) e.target.reset();
  }catch{ msg.textContent='Gagal terhubung'; msg.className='text-sm mt-3 p-3 rounded-xl bg-red-50 text-red-700';}
});

// Newsletter
document.getElementById('newsletterForm')?.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const email=e.target.email.value;
  const msg=document.getElementById('newsletterMsg');
  try{
    const r=await fetch('/api/newsletter',{method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({email})});
    const j=await r.json();
    msg.textContent=j.message; msg.classList.remove('hidden'); msg.className='text-xs mt-2 '+(j.success?'text-green-300':'text-red-300');
  }catch{ msg.textContent='Gagal'; msg.classList.remove('hidden');}
});

// Contact form
document.getElementById('contactForm')?.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const fd=new FormData(e.target);
  const body=Object.fromEntries(fd.entries());
  const msg=document.getElementById('contactMsg');
  msg.textContent='Mengirim...'; msg.classList.remove('hidden');
  const r=await fetch('/api/contact',{method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(body)});
  const j=await r.json();
  msg.textContent=j.message;
  msg.className='text-sm mt-3 p-3 rounded-xl '+(j.success?'bg-green-50 text-green-700':'bg-red-50 text-red-700');
  msg.classList.remove('hidden');
  if(j.success) e.target.reset();
});

// FAQ accordion
document.querySelectorAll('[data-faq]')?.forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const content=btn.nextElementSibling;
    const isOpen=!content.classList.contains('hidden');
    document.querySelectorAll('[data-faq] + div').forEach(d=>d.classList.add('hidden'));
    if(!isOpen) content.classList.remove('hidden');
  });
});

// Pricing toggle
const toggle=document.getElementById('pricingToggle');
if(toggle){
  toggle.addEventListener('change', (e)=>{
    document.querySelectorAll('[data-price]').forEach(el=>{
      const m=el.dataset.monthly, y=el.dataset.yearly;
      el.textContent=e.target.checked ? y : m;
    });
    document.querySelectorAll('[data-period]').forEach(el=>{
      el.textContent=e.target.checked ? '/tahun' : '/bulan';
    });
  });
}

// Category filter (classes page)
document.querySelectorAll('[data-filter]')?.forEach(a=>{
  a.addEventListener('click', (e)=>{
    // allow normal navigation; fallback JS filter for same-page
  });
});

// Gallery lightbox
let lightboxImgs=[];
window.openLightbox=(src, idx)=>{
  lightboxImgs = Array.from(document.querySelectorAll('[data-gallery]')).map(i=>i.src);
  const lb=document.getElementById('lightbox');
  if(!lb) return;
  lb.querySelector('img').src=src;
  lb.classList.remove('hidden');
  lb.dataset.idx=idx;
}
window.closeLightbox=()=> document.getElementById('lightbox')?.classList.add('hidden');
window.lightboxNav=(dir)=>{
  const lb=document.getElementById('lightbox');
  let idx=parseInt(lb.dataset.idx||'0')+dir;
  if(idx<0) idx=lightboxImgs.length-1;
  if(idx>=lightboxImgs.length) idx=0;
  lb.dataset.idx=idx;
  lb.querySelector('img').src=lightboxImgs[idx];
}

// Dark mode toggle
const darkBtn = document.getElementById('darkToggle');
function applyDark(isDark){
  document.documentElement.classList.toggle('dark', isDark);
  try{ localStorage.setItem('serene-dark', isDark); }catch(e){}
  if(darkBtn) darkBtn.textContent = isDark ? '☀' : '◐';
}
if(darkBtn){
  // init icon
  darkBtn.textContent = document.documentElement.classList.contains('dark') ? '☀' : '◐';
  darkBtn.addEventListener('click', ()=>{
    const isDark = !document.documentElement.classList.contains('dark');
    applyDark(isDark);
  });
}

// Reveal on scroll
const observer=new IntersectionObserver((entries)=>{
  entries.forEach(ent=>{
    if(ent.isIntersecting) ent.target.classList.add('!opacity-100','!translate-y-0');
  });
},{threshold:0.1});
document.querySelectorAll('.reveal').forEach(el=>{
  el.classList.add('opacity-0','translate-y-6','transition','duration-700');
  observer.observe(el);
});

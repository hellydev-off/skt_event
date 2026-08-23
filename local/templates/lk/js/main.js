$(document).ready(function() {
  $('body').on('click','.lk_change_status',function(e){
    var gid=$(this).attr('data-status');
    $.post('/local/templates/lk/ajax/change_status.php',{'gid':gid},function(data){
      location.href='/lk.php';
    });
    e.preventDefault();
    return false;
  });
});
function showFiles(input) { 
  const previewsContainer = 
    document.getElementById('imagePreviews'); 
    
  previewsContainer.innerHTML = ''; 
  const files = input.files; 
  for (let i = 0; i < files.length; i++) { 
    const file = files[i]; 
    const reader = new FileReader(); 
    reader.onload = function (e) { 
      const preview = document.createElement('div'); 
      preview.classList.add('col-md-4', 'mb-3'); 
      preview.innerHTML = ` 
  <img src="${e.target.result}" alt="Preview" class="img-fluid rounded"> 
  <div class="text-center mt-2"> 
  <span class="badge bg-secondary">${file.name}</span> 
  </div> 
`; 
      previewsContainer.appendChild(preview); 
    }; 
    reader.readAsDataURL(file); 
  } 
} 
function showFiles2(input) { 
  const previewsContainer = 
    document.getElementById('imagePreviews2'); 
    
  previewsContainer.innerHTML = ''; 
  const files = input.files; 
  for (let i = 0; i < files.length; i++) { 
    const file = files[i]; 
    const reader = new FileReader(); 
    reader.onload = function (e) { 
      const preview = document.createElement('div'); 
      preview.classList.add('col-md-4', 'mb-3'); 
      preview.innerHTML = ` 
  <img src="${e.target.result}" alt="Preview" class="img-fluid rounded"> 
  <div class="text-center mt-2"> 
  <span class="badge bg-secondary">${file.name}</span> 
  </div> 
`; 
      previewsContainer.appendChild(preview); 
    }; 
    reader.readAsDataURL(file); 
  } 
} 

function showFiles3(input,n) { 
  const previewsContainer = 
    document.getElementById('imagePreviews'+n); 
    
  previewsContainer.innerHTML = ''; 
  const files = input.files; 
  for (let i = 0; i < files.length; i++) { 
    const file = files[i]; 
    const reader = new FileReader(); 
    reader.onload = function (e) { 
      const preview = document.createElement('div'); 
      preview.classList.add('col-md-4', 'mb-3'); 
      preview.innerHTML = ` 
  <img src="${e.target.result}" alt="Preview" class="img-fluid rounded"> 
  <div class="text-center mt-2"> 
  <span class="badge bg-secondary">${file.name}</span> 
  </div> 
`; 
      previewsContainer.appendChild(preview); 
    }; 
    reader.readAsDataURL(file); 
  } 
} 
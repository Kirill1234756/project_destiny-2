
// Season of desire
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.link-tab').forEach(function(tabLink) {
      tabLink.addEventListener('click', function(event) {
        const path = event.currentTarget.dataset.path
        document.querySelectorAll('.link-tab').forEach(function(tabContent){
          tabContent.classList.remove('btn_active')
        });
        event.currentTarget.classList.add("btn_active")
        document.querySelectorAll('.box').forEach(function(tabContent) {
          tabContent.classList.remove('box_active')
        })
        document.querySelector(`[data-target="${path}"]`).classList.add('box_active')
      })
    })
  })


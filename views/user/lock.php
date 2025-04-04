<div class="container-fluid section-home d-flex justify-content-center align-items-center">
    <div class="col-12 px-3 px-md-5 py-5">
        <p class="display-1 text-white text-center">
            Coming Soon !
        </p>
    </div>
</div>

<script>
    const paragraph = document.querySelector('p');
    const text = paragraph.textContent;
    paragraph.textContent = '';

    let i = 0;
    function typeWriter() {
        if (i < text.length) {
            paragraph.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 60); // Chạy chữ với tốc độ 50ms/ký tự
        }
    }

    typeWriter();
</script>
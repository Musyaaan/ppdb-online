document.addEventListener("DOMContentLoaded", function () {
  const testimonials = [
    {
      text: "SD Negeri Legok III benar-benar luar biasa. Anak saya tumbuh tidak hanya pintar secara akademik, tapi juga memiliki karakter yang baik dan sopan santun yang terjaga.",
      author: "Ibu Sari Dewi",
      role: "Orang tua dari kelas 5A",
    },
    {
      text: "Guru-gurunya sangat sabar dan peduli. Anak saya yang tadinya pemalu kini berani tampil di depan kelas dan aktif dalam berbagai kegiatan sekolah.",
      author: "Bapak Rudi Hartono",
      role: "Orang tua dari kelas 6B",
    },
    {
      text: "Lingkungan sekolahnya bersih, aman, dan nyaman. Saya merasa tenang menitipkan anak di sini karena sekolah selalu terbuka dalam berkomunikasi dengan orang tua.",
      author: "Ibu Maya Kusuma",
      role: "Orang tua dari kelas 3C",
    },
    {
      text: "Program ekstrakulikulernya sangat beragam. Anak saya sangat menikmati kegiatan pramuka dan seni, dan perkembangannya terlihat nyata sejak bergabung di sini.",
      author: "Bapak Andi Prasetyo",
      role: "Orang tua dari kelas 4A",
    },
    {
      text: "Saya sangat puas dengan pendidikan di SDN Legok III. Nilai-nilai agama dan moral diajarkan dengan baik tanpa mengabaikan prestasi akademik anak.",
      author: "Ibu Fitri Rahayu",
      role: "Orang tua dari kelas 2B",
    },
    {
      text: "Kepala sekolah dan para guru sangat profesional. Mereka benar-benar memperhatikan perkembangan setiap anak, bukan hanya nilai rapor tapi juga karakter dan kebahagiaan anak.",
      author: "Bapak Doni Setiawan",
      role: "Orang tua dari kelas 1A",
    },
    {
      text: "Anak saya jadi lebih disiplin sejak bersekolah di sini. Setiap hari selalu semangat berangkat dan jarang sekali mengeluh.",
      author: "Ibu Lina Marlina",
      role: "Orang tua dari kelas 4B",
    },
    {
      text: "Fasilitas sekolahnya cukup lengkap dan mendukung proses belajar. Anak-anak jadi lebih mudah memahami pelajaran.",
      author: "Bapak Agus Santoso",
      role: "Orang tua dari kelas 5C",
    },
    {
      text: "Guru-guru di sini sangat perhatian dan tidak segan membantu siswa yang mengalami kesulitan belajar.",
      author: "Ibu Ratna Wulandari",
      role: "Orang tua dari kelas 3A",
    },
    {
      text: "Saya melihat perkembangan yang signifikan pada anak saya, terutama dalam hal kepercayaan diri dan kemampuan berkomunikasi.",
      author: "Bapak Hendra Wijaya",
      role: "Orang tua dari kelas 6A",
    },
    {
      text: "Kegiatan sekolahnya sangat positif dan mendidik. Anak saya jadi lebih aktif dan kreatif setelah mengikuti berbagai program.",
      author: "Ibu Dewi Anggraini",
      role: "Orang tua dari kelas 2A",
    },
    {
      text: "Lingkungan yang ramah dan guru yang sabar membuat anak saya betah belajar di sekolah ini.",
      author: "Bapak Eko Prasetyo",
      role: "Orang tua dari kelas 1B",
    },
    {
      text: "Komunikasi antara sekolah dan orang tua sangat baik. Setiap perkembangan anak selalu diinformasikan dengan jelas.",
      author: "Ibu Yuni Kartika",
      role: "Orang tua dari kelas 5B",
    },
    {
      text: "Anak saya jadi lebih mandiri dan bertanggung jawab sejak bersekolah di SD Negeri Legok III.",
      author: "Bapak Arif Nugroho",
      role: "Orang tua dari kelas 4C",
    },
    {
      text: "Program pembelajaran yang diterapkan sangat menarik dan tidak membosankan bagi anak-anak.",
      author: "Ibu Siska Lestari",
      role: "Orang tua dari kelas 3B",
    },
    {
      text: "Sekolah ini sangat memperhatikan nilai moral dan etika, yang menurut saya sangat penting bagi perkembangan anak.",
      author: "Bapak Wahyu Setiawan",
      role: "Orang tua dari kelas 6C",
    },
    {
      text: "Anak saya selalu bercerita hal-hal positif tentang kegiatan di sekolah, itu membuat saya yakin dengan kualitas pendidikan di sini.",
      author: "Ibu Rina Oktaviani",
      role: "Orang tua dari kelas 2C",
    },
    {
      text: "Guru-gurunya ramah dan mudah diajak berdiskusi. Kami sebagai orang tua merasa dilibatkan dalam pendidikan anak.",
      author: "Bapak Dedi Kurniawan",
      role: "Orang tua dari kelas 1C",
    },
    {
      text: "Sekolah memberikan banyak kesempatan bagi siswa untuk mengembangkan bakat dan minat mereka.",
      author: "Ibu Nur Aisyah",
      role: "Orang tua dari kelas 5A",
    },
    {
      text: "Saya sangat mengapresiasi pendekatan pembelajaran yang kreatif dan inovatif di sekolah ini.",
      author: "Bapak Fajar Ramadhan",
      role: "Orang tua dari kelas 4A",
    },
    {
      text: "Anak saya merasa senang dan nyaman belajar di sini. Itu yang paling penting bagi saya sebagai orang tua.",
      author: "Ibu Melati Puspita",
      role: "Orang tua dari kelas 3C",
    },
  ];

  function shuffle(arr) {
    return arr.slice().sort(() => Math.random() - 0.5);
  }

  let pool = [];
  let currentPair = [];

  function getNextPair() {
    if (pool.length < 2) {
      pool = shuffle(testimonials);
      if (currentPair.length === 2) {
        while (pool[0] === currentPair[0] || pool[0] === currentPair[1]) {
          pool = shuffle(testimonials);
        }
      }
    }
    currentPair = [pool.shift(), pool.shift()];
    return currentPair;
  }

  function renderTestimonials() {
    const [a, b] = getNextPair();
    const cards = document.querySelectorAll(".testi-card");

    cards.forEach((card) => (card.style.opacity = "0"));

    setTimeout(() => {
      document.getElementById("testi-text-1").textContent = a.text;
      document.getElementById("testi-author-1").textContent = a.author;
      document.getElementById("testi-role-1").textContent = a.role;

      document.getElementById("testi-text-2").textContent = b.text;
      document.getElementById("testi-author-2").textContent = b.author;
      document.getElementById("testi-role-2").textContent = b.role;

      cards.forEach((card) => (card.style.transition = "opacity 0.6s ease"));
      cards.forEach((card) => (card.style.opacity = "1"));
    }, 400);
  }

  renderTestimonials();
  setInterval(renderTestimonials, 6000);

  // Navbar berubah putih saat discroll
  const navbar = document.querySelector(".navbar");
  window.addEventListener("scroll", function () {
    if (window.scrollY > 50) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  });

  // Hero background crossfade
  const heroBgs = document.querySelectorAll(".hero-bg");
  let heroCurrent = 0;
  heroBgs[0].classList.add("active");

  setInterval(() => {
    heroBgs[heroCurrent].classList.remove("active");
    heroCurrent = (heroCurrent + 1) % heroBgs.length;
    heroBgs[heroCurrent].classList.add("active");
  }, 4000);
});
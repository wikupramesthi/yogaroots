/**
 * Data statis theme (non-CMS).
 * Konten dinamis (kelas, paket, event, artikel, dst.) berasal dari backend via services/.
 * Jangan taruh konten CMS di sini — file ini hanya untuk identitas & navigasi.
 */
export const yogaData = {
  site: {
    name: "Yoga Roots",
    tagline: "Yoga, Meditation & Wellness",
    description:
      "Through our guidance, you will not only gain a deeper understanding of the postures but also learn to cultivate mental clarity and inner peace.",
    phone: "+62 813 2122 1270",
    email: "halo@serene.yoga",
    address:
      "Roots Prasasta Building, Jl. Kawi Raya No.37, RT.6/RW.2, Guntur, Setiabudi, South Jakarta City, Jakarta 12980",
    instagram: "yogaroot.id",
    year: new Date().getFullYear(),
  },
  nav: [
    { key: "about", label: "About", href: "/about" },
    { key: "classes", label: "Classes", href: "/classes" },
    { key: "schedules", label: "Schedules", href: "/schedules" },
    { key: "packages", label: "Packages", href: "/packages" },
    { key: "instructors", label: "Instructors", href: "/instructors" },
    { key: "artofliving", label: "Art of Living", href: "/art-of-living" },
  ],
  contact: {
    mapEmbed:
      "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4880.551036860198!2d106.83020387586802!3d-6.20872306081883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f591a35191c3%3A0x255c635679625e83!2sYoga%20Roots!5e1!3m2!1sen!2sid!4v1791260834023!5m2!1sen!2sid",
  },
};

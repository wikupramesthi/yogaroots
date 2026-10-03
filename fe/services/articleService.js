import apiRequest from "./apiClient.js";

const DATE_LOCALES = {
  en: "en-US",
  id: "id-ID",
  ja: "ja-JP",
  ko: "ko-KR",
  zh: "zh-CN",
};

const READ_TIME = {
  en: "5 min read",
  id: "5 mnt baca",
  ja: "5分で読めます",
  ko: "5분 읽기",
  zh: "阅读约 5 分钟",
};

function formatArticle(article, lang = "en") {
  const locale = DATE_LOCALES[lang] || DATE_LOCALES.en;
  return {
    id: article.uuid,
    slug: article.slug,
    title: article.title,
    content: article.content,

    // API Laravel menggunakan featured_image
    image: article.featured_image || "",

    category: article.category || "",

    date: article.created_at
      ? new Date(article.created_at).toLocaleDateString(locale, {
          day: "2-digit",
          month: "short",
          year: "numeric",
        })
      : "",

    read: READ_TIME[lang] || READ_TIME.en,

    excerpt: article.excerpt || "",
  };
}

export async function getArticles(lang = "en") {
  const articles = await apiRequest("/articles");
  return articles.map((article) => formatArticle(article, lang));
}

export async function getArticle(slug, lang = "en") {
  const article = await apiRequest(`/articles/${slug}`);
  if (!article) return null;
  return formatArticle(article, lang);
}

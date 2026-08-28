import apiRequest from "./apiClient.js";

export async function getArticles() {
  const articles = await apiRequest("/articles");

  return articles.map((article) => ({
    id: article.uuid,
    slug: article.slug,
    title: article.title,
    content: article.content,

    // API Laravel menggunakan featured_image
    image: article.featured_image || "",

    category: article.category || "",

    date: article.created_at
      ? new Date(article.created_at).toLocaleDateString("id-ID", {
          day: "2-digit",
          month: "short",
          year: "numeric",
        })
      : "",

    read: "5 min read",

    excerpt: article.excerpt || "",
  }));
}

export async function getArticle(slug) {
  const article = await apiRequest(`/articles/${slug}`);

  if (!article) return null;

  return {
    id: article.uuid,
    slug: article.slug,
    title: article.title,
    content: article.content,

    image: article.featured_image || "",

    category: article.category || "",

    date: article.created_at
      ? new Date(article.created_at).toLocaleDateString("id-ID", {
          day: "2-digit",
          month: "short",
          year: "numeric",
        })
      : "",

    read: "5 min read",

    excerpt: article.excerpt || "",
  };
}

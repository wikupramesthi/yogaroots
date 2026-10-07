import type { Article, BackendPayload } from "../types/index.js";
import apiRequest from "./apiClient.js";

const DATE_LOCALES: Record<string, string> = {
	en: "en-US",
	id: "id-ID",
	ja: "ja-JP",
	ko: "ko-KR",
	zh: "zh-CN",
};

const READ_TIME: Record<string, string> = {
	en: "5 min read",
	id: "5 mnt baca",
	ja: "5分で読めます",
	ko: "5분 읽기",
	zh: "阅读约 5 分钟",
};

function formatArticle(article: Record<string, any>, lang = "en"): Article {
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

export async function getArticles(lang = "en"): Promise<Article[]> {
	const articles: BackendPayload = await apiRequest("/articles");
	return (Array.isArray(articles) ? articles : []).map((article) =>
		formatArticle(article, lang),
	);
}

export async function getArticle(
	slug: string,
	lang = "en",
): Promise<Article | null> {
	const article: BackendPayload = await apiRequest(
		`/articles/${encodeURIComponent(slug)}`,
	);
	if (!article) return null;
	return formatArticle(article, lang);
}

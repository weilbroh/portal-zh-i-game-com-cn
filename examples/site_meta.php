<?php

/**
 * 站点元信息配置与描述生成器
 * 用于维护站点基础元数据，并可根据需要生成简短的中文描述文本。
 */

class SiteMeta
{
    /**
     * 站点信息数组
     * 包含站点的基础配置数据
     */
    private array $meta = [];

    /**
     * 构造函数，初始化站点元信息
     */
    public function __construct()
    {
        $this->meta = [
            'site_name'        => '爱游戏',
            'site_url'         => 'https://portal-zh-i-game.com.cn',
            'site_description' => '综合游戏资讯与互动平台',
            'keywords'         => ['爱游戏', '游戏攻略', '游戏资讯', '玩家社区'],
            'author'           => '爱游戏团队',
            'version'          => '1.0.0',
            'language'         => 'zh-CN',
            'charset'          => 'UTF-8',
            'year'             => date('Y'),
        ];
    }

    /**
     * 获取指定键的元信息
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key): mixed
    {
        return $this->meta[$key] ?? null;
    }

    /**
     * 获取所有元信息
     * @return array
     */
    public function getAll(): array
    {
        return $this->meta;
    }

    /**
     * 生成站点的简短描述文本
     * 描述中包含站点名称、URL 和核心关键词
     * @param bool $includeUrl 是否包含 URL
     * @return string
     */
    public function generateShortDescription(bool $includeUrl = true): string
    {
        $name = $this->meta['site_name'];
        $desc = $this->meta['site_description'];
        $keyword = $this->meta['keywords'][0] ?? '爱游戏';

        $result = "{$name}——{$desc}，核心关键词：{$keyword}";

        if ($includeUrl && !empty($this->meta['site_url'])) {
            $url = $this->meta['site_url'];
            $escapedUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            $result .= " 访问地址：{$escapedUrl}";
        }

        return $result;
    }

    /**
     * 生成带有 HTML 标签的元信息区块（用于页面头部）
     * @return string
     */
    public function renderMetaTags(): string
    {
        $name = htmlspecialchars($this->meta['site_name'], ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($this->meta['site_description'], ENT_QUOTES, 'UTF-8');
        $url  = htmlspecialchars($this->meta['site_url'], ENT_QUOTES, 'UTF-8');
        $keywords = implode(', ', array_map(function($kw) {
            return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
        }, $this->meta['keywords']));
        $author = htmlspecialchars($this->meta['author'], ENT_QUOTES, 'UTF-8');
        $charset = htmlspecialchars($this->meta['charset'], ENT_QUOTES, 'UTF-8');

        $tags = [];
        $tags[] = '<meta charset="' . $charset . '">';
        $tags[] = '<meta name="author" content="' . $author . '">';
        $tags[] = '<meta name="description" content="' . $desc . '">';
        $tags[] = '<meta name="keywords" content="' . $keywords . '">';
        $tags[] = '<meta name="application-name" content="' . $name . '">';
        $tags[] = '<link rel="canonical" href="' . $url . '">';

        return implode("\n", $tags) . "\n";
    }

    /**
     * 生成一个简单的站点标识字符串
     * @return string
     */
    public function getSiteSignature(): string
    {
        $name = $this->meta['site_name'];
        $url  = $this->meta['site_url'];
        $ver  = $this->meta['version'];
        return "{$name} v{$ver} | {$url}";
    }

    /**
     * 检查当前年份是否与配置中的年份一致（用于版权提示）
     * @return bool
     */
    public function isCurrentYear(): bool
    {
        return $this->meta['year'] === (int)date('Y');
    }

    /**
     * 更新某个元信息项
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->meta[$key] = $value;
    }
}

// 示例用法
$siteMeta = new SiteMeta();

// 输出简短描述
echo $siteMeta->generateShortDescription() . PHP_EOL;

// 输出站点签名
echo $siteMeta->getSiteSignature() . PHP_EOL;

// 输出 HTML meta 标签（供页面头部使用）
echo PHP_EOL . "<!-- 以下为 Meta 标签示例 -->" . PHP_EOL;
echo $siteMeta->renderMetaTags();
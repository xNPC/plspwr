<?php

declare(strict_types=1);

namespace App\Orchid\Screens\News;

use App\Models\Post;
use App\Orchid\Layouts\News\PostEditLayout;
use App\Orchid\Layouts\Seo\SeoEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostEditScreen extends Screen
{
    /**
     * @var Post
     */
    public $post;

    public function query(Post $post): iterable
    {
        $post->load('seo');

        if (! $post->exists && empty($post->published_at)) {
            $post->published_at = now();
        }

        return [
            'post' => $post,
            'seo' => $post->seo,
        ];
    }

    public function name(): ?string
    {
        return $this->post->exists ? __('Edit Post') : __('Create Post');
    }

    public function description(): ?string
    {
        return $this->post->exists ? $this->post->title_ru : __('Add a new news post or event.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.news'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Delete this post?'))
                ->method('remove')
                ->canSee($this->post->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(PostEditLayout::class)
                ->title(__('Post'))
                ->description(__('Localized fields for this post.')),

            Layout::block(SeoEditLayout::class)
                ->title(__('SEO'))
                ->description(__('Search engine metadata (optional).')),
        ];
    }

    public function save(Post $post, Request $request): RedirectResponse
    {
        $data = $request->collect('post')->toArray();
        $data['image'] = $this->normalizeImage($data['image'] ?? null);

        $post->fill($data)->save();

        $seoData = $request->collect('seo')->toArray();
        if (! empty($seoData['title_ru']) || ! empty($seoData['title_en']) || ! empty($seoData['description_ru'])) {
            $post->seo()->updateOrCreate([], $seoData);
        }

        Toast::info(__('Post was saved.'));

        return redirect()->route('platform.content.news.edit', $post->id);
    }

    public function remove(Post $post): RedirectResponse
    {
        $post->delete();

        Toast::info(__('Post was removed.'));

        return redirect()->route('platform.content.news');
    }

    private function normalizeImage(mixed $value): ?string
    {
        $first = null;

        if (is_array($value)) {
            $flat = array_values(array_filter($value, fn ($item) => is_string($item) && trim($item) !== ''));
            $first = $flat[0] ?? null;
        } elseif (is_string($value) && trim($value) !== '') {
            $decoded = json_decode($value, true);

            if (is_array($decoded)) {
                $flat = array_values(array_filter($decoded, fn ($item) => is_string($item) && trim($item) !== ''));
                $first = $flat[0] ?? null;
            } else {
                $first = $value;
            }
        }

        return $first !== null ? (string) $first : null;
    }
}

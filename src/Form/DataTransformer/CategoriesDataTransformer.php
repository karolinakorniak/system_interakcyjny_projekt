<?php
/**
 * Tags data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Category;
use App\Service\CategoryServiceInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class CategoriesDataTransformer.
 *
 * @implements DataTransformerInterface<mixed, mixed>
 */
class CategoriesDataTransformer implements DataTransformerInterface
{
    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Security
     */
    private Security $security;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     */
    public function __construct(CategoryServiceInterface $categoryService, Security $security)
    {
        $this->categoryService = $categoryService;
        $this->security = $security;
    }

    /**
     * Transform array of categories to string of category names.
     *
     * @param Collection<int, Category> $value Category entity collection
     *
     * @return string Result
     */
    public function transform($value): string
    {
        if ($value->isEmpty()) {
            return '';
        }

        $names = [];

        foreach ($value as $category) {
            $names[] = $category->getName();
        }

        return implode(', ', $names);
    }

    /**
     * Transform string of category names into array of Category entities.
     *
     * @param string $value String of Category names
     *
     * @return array<int, Category> Result
     */
    public function reverseTransform($value): array
    {
        $categoryNames = explode(',', $value);

        $categories = [];

        foreach ($categoryNames as $categoryName) {
            $trimmedName = trim($categoryName);
            if ('' !== $trimmedName) {
                $category = $this->categoryService->findOneByName(strtolower($trimmedName));
                if (null === $category) {
                    $category = new Category();
                    $category->setName($trimmedName);
                    $category->setAuthor($this->security->getUser());

                    $this->categoryService->saveCategory($category);
                }
                $categories[] = $category;
            }
        }

        return $categories;
    }
}

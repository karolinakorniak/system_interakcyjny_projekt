<?php
/**
 * Question Type.
 */

namespace App\Form\Type;

use App\Entity\Question;
use App\Form\DataTransformer\CategoriesDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class QuestionType.
 */
class QuestionType extends AbstractType
{
    /**
     * Categories data transformer.
     */
    private CategoriesDataTransformer $categoriesDataTransformer;

    /**
     * Constructor.
     *
     * @param CategoriesDataTransformer $categoriesDataTransformer Transformer for categories
     */
    public function __construct(CategoriesDataTransformer $categoriesDataTransformer)
    {
        $this->categoriesDataTransformer = $categoriesDataTransformer;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'questions.labels.title',
                'required' => true,
                'attr' => ['maxlength' => 150, 'minlength' => 3],
            ]
        )->add(
            'content',
            TextareaType::class,
            [
            'label' => 'questions.labels.content',
            'required' => true,
            'attr' => ['maxlength' => 500, 'minlength' => 3],
            ]
        )->add(
            'categories',
            TextType::class,
            [
            'label' => 'questions.labels.categories',
            'required' => false,
            ]
        );

        $builder->get('categories')->addModelTransformer($this->categoriesDataTransformer);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Question::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'question';
    }
}

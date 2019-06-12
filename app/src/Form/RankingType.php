<?php
/**
 * Ranking type.
 */
namespace App\Form;
use App\Entity\Destination;
use App\Entity\Ranking;
use App\Entity\Grade;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Class RankingType.
 */
class RankingType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'grade',
            EntityType::class,
            [
                'class' => Grade::class,
                'choice_label' => function ($grade) {
                    return $grade->getValue();
                },
                'label' => 'label.grade',
                'required' => true,
            ]
        );
        /*
        $builder->add(
            'destination',
            EntityType::class,
            [
                'class' => Destination::class,
                'choice_label' => function ($destination) {
                    return $destination->getTitle();
                },
                'label' => 'label.destination',
                'placeholder' => ' ',
                'required' => true,
            ]
        ); */
    }
    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Ranking::class]);
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
        return 'ranking';
    }
}

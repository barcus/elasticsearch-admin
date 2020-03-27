<?php

namespace App\Form;

use App\Model\ElasticsearchSlmPolicyModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateSlmPolicyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fields = [];

        $fields[] = 'name';
        $fields[] = 'snapshot_name';
        $fields[] = 'repository';
        $fields[] = 'indices';
        $fields[] = 'schedule';
        $fields[] = 'expire_after';
        $fields[] = 'min_count';
        $fields[] = 'max_count';
        $fields[] = 'ignore_unavailable';
        $fields[] = 'partial';
        $fields[] = 'include_global_state';

        foreach ($fields as $field) {
            switch ($field) {
                case 'name':
                    $builder->add('name', TextType::class, [
                        'label' => 'name',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ],
                    ]);
                    break;
                case 'snapshot_name':
                    $builder->add('snapshot_name', TextType::class, [
                        'label' => 'snapshot_name',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ],
                    ]);
                    break;
                case 'repository':
                    $builder->add('repository', ChoiceType::class, [
                        'placeholder' => '-',
                        'choices' => $options['repositories'],
                        'choice_label' => function ($choice, $key, $value) use ($options) {
                            return $options['repositories'][$key];
                        },
                        'choice_translation_domain' => false,
                        'label' => 'repository',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ],
                        'attr' => ['data-break-after' => 'yes'],
                    ]);
                    break;
                case 'indices':
                    $builder->add('indices', ChoiceType::class, [
                        'multiple' => true,
                        'choices' => $options['indices'],
                        'choice_label' => function ($choice, $key, $value) use ($options) {
                            return $options['indices'][$key];
                        },
                        'choice_translation_domain' => false,
                        'label' => 'indices',
                        'required' => false,
                        'attr' => [
                            'size' => 10
                        ],
                    ]);
                    break;
                case 'schedule':
                    $builder->add('schedule', TextType::class, [
                        'label' => 'schedule',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ],
                    ]);
                    break;
                case 'expire_after':
                    $builder->add('expire_after', TextType::class, [
                        'label' => 'expire_after',
                        'required' => false,
                    ]);
                    break;
                case 'min_count':
                    $builder->add('min_count', IntegerType::class, [
                        'label' => 'min_count',
                        'required' => false,
                    ]);
                    break;
                case 'max_count':
                    $builder->add('max_count', IntegerType::class, [
                        'label' => 'max_count',
                        'required' => false,
                    ]);
                    break;
                case 'ignore_unavailable':
                    $builder->add('ignore_unavailable', CheckboxType::class, [
                        'label' => 'ignore_unavailable',
                        'required' => false,
                    ]);
                    break;
                case 'partial':
                    $builder->add('partial', CheckboxType::class, [
                        'label' => 'partial',
                        'required' => false,
                    ]);
                    break;
                case 'include_global_state':
                    $builder->add('include_global_state', CheckboxType::class, [
                        'label' => 'include_global_state',
                        'required' => false,
                    ]);
                    break;
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ElasticsearchSlmPolicyModel::class,
            'repositories' => [],
            'indices' => [],
        ]);
    }

    public function getBlockPrefix()
    {
        return 'data';
    }
}

/**
 * Register block collection for all sht blocks
 * https://make.wordpress.org/core/2020/02/27/block-collections/
 *
 * 4.3.2022 mark@sayhello.ch
 */

import { registerBlockCollection } from '@wordpress/blocks';
import { sayhello as icon } from '../icons';

registerBlockCollection('sht', {
    title: 'Say Hello Theme',
    icon,
});

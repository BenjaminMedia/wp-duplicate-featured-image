<?php

class featured_image_helper
{
	/**
	 * set thumbnail for post from attachments
	 * @param $id
	 */
	public function set_post_thumbnail($id)
	{
		$thumbnail_url = get_the_post_thumbnail_url($id, 'full');
		if (!$thumbnail_url) {
			$attachments = get_attached_media('image', $id);
			if (count($attachments) > 0) {
				ksort($attachments);
				foreach ($attachments as $key => $value) {
					set_post_thumbnail($id, $key);
					break;
				}
			}
		}
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 27/11/2015
 * Time: 9:13 AM
 */

require_once __DIR__ . '/bitbucket-api/vendor/autoload.php';

function thim_get_repositories_users_cloneable( $user_bb, $pass_bb ) {
	try {
		$user = new Bitbucket\API\User();
		$user->getClient()->addListener( new Bitbucket\API\Http\Listener\BasicAuthListener( $user_bb, $pass_bb ) );

		$repos          = $user->repositories()->get();
		$content_respos = $repos->getContent();
		$object_repos   = json_decode( $content_respos );

		$arr_repos = [ ];
		if ( count( $object_repos ) > 0 ) {
			foreach ( $object_repos as $index => $repo ) {
				$r               = [ ];
				$r['slug']       = $repo->slug;
				$r['owner']      = $repo->owner;
				$r['is_private'] = $repo->is_private;
				$r['link_clone'] = 'https://' . $user_bb . '@bitbucket.org/' . $repo->owner . '/' . $repo->slug
				                   . '.git';

				$arr_repos[] = $r;
			}
		}

		return $arr_repos;
	} catch ( Exception $e ) {
		return null;
	}
}
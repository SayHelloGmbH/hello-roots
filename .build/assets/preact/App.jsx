import React from 'react';
import ReactDOM from 'react-dom';

const App = () => {
	const [liked, setLiked] = React.useState(false);

	React.useEffect(() => {

		}, []
	);

	return <div>
		<button className={`button ${liked ? 'button--liked' : ''}`} disabled={liked}
				style={{backgroundColor: liked ? 'pink' : 'blue'}} onClick={() => {
			if (liked) {
				alert('already liked');
			}
			$.get({
				url: 'https://wordpress.hello/wp-json/wp/v2/',
				success: () => {
					setLiked(true);
				},
			});
		}}>
			like
		</button>

	</div>
}

const appElement = document.querySelector('#preact');

if (appElement) {
	ReactDOM.render(
		<App/>,
		appElement
	);
}


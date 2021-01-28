import React from 'react';
import ReactDOM from 'react-dom';

const App = () => {
	const [page, setPage] = React.useState(1);
	const [pageSize, setPageSize] = React.useState(20);
	const [data, setData] = React.useState([]);

	const query = React.useMemo(() => `page=${page}&pageSize=${pageSize}`, [page, pageSize]);

	React.useEffect(() => {
		fetch(`myendpoint?${query}`)
			.then(resp => resp.json())
			.then(data => setData(data));
	}, [query]);

	return <div>
		<ul>
			{data.map(bird => <li>{bird.name}</li>)}
		</ul>
		Page: {[1, 2, 3, 4, 5].map(p => <button onClick={() => setPage(p)}>{p}</button>)}<br />
		PageSize: {[10, 20, 30, 40, 50].map(p => <button onClick={() => setPageSize(p)}>{p}</button>)}
	</div>
}

const appElement = document.querySelector('#preact');

if (appElement) {
	ReactDOM.render(
		<App/>,
		appElement
	);
}


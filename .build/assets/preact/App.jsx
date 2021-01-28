import React from 'react';
import ReactDOM from 'react-dom';

const App = () => {
	const [count, setCount] = React.useState(0);

	const double = React.useMemo(() => count * 2, [count]);

	React.useEffect(() => {
		console.log('APP INITIALIZED');
		return () => console.log('APP DESTROYED');
	}, []);

	React.useEffect(() => {
		console.log('COUNT UPDATED:', count);
	}, [count]);

	return <div>
		<h2>Count: {count} ({double})</h2>
		<button onClick={() => setCount(count + 1)}>+</button>
		<button onClick={() => setCount(count - 1)}>-</button>
	</div>
}

ReactDOM.render(
	<App/>,
	document.querySelector('#preact')
);

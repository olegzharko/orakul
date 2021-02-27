import React, { useState, useEffect } from 'react';
import './GridLayout.scss';
import RGL, { WidthProvider } from 'react-grid-layout';
import $ from 'jquery';
import { useSelector, useDispatch } from 'react-redux';

// redux
import { setLayouts } from '../../../../store/actions';

const ReactGridLayout = WidthProvider(RGL);

export default function GridLayout() {
  const [dragAndDropWidth, setDragAndDropWidth] = useState(1200);
  const layouts = useSelector((state) => state.layouts);
  const dispatch = useDispatch();

  useEffect(() => {
    setDragAndDropWidth($('.scheduler__appointments').width());
  }, []);

  const handleDrag = (all, current) => {
    const currentApp = all.find((item) => item.i === current.i);
    const newLayouts = layouts.map((item) => {
      if (item.i === current.i) {
        item.x = currentApp.x;
        item.y = currentApp.y;
      }

      return item;
    });
    dispatch(setLayouts(newLayouts));
  };

  const handleDoubleClick = () => {
    console.log('double');
  };

  if (layouts.length === 0) {
    return <span>Loading...</span>;
  }

  return (
    <ReactGridLayout
      className="scheduler__dragAndDrop"
      cols={6}
      rowHeight={48}
      width={dragAndDropWidth}
      margin={[0, 0]}
      containerPadding={[0, 0]}
      verticalCompact={false}
      preventCollision
      layout={layouts}
      onDragStop={handleDrag}
    >
      {layouts.map(({ i, title }) => (
        <div
          key={i}
          className="appointment"
          style={{}}
          onDoubleClick={handleDoubleClick}
        >
          <div className="appointment__title">{title}</div>
          <table className="appointment__table">
            <tbody>
              <tr>
                <td>СВ</td>
                <td>КВ</td>
                <td>ОВ</td>
                <th>ЛК</th>
              </tr>
            </tbody>
          </table>
        </div>
      ))}
    </ReactGridLayout>
  );
}

import * as React from 'react';
import './index.scss';

type Props = {
  children: React.ReactNode
}

const ControlPanel = ({ children }: Props) => (
  // непосредственно та часть в которой выводятся разделы кнопки меню c Navigation.tsx
  <div className="controlPanel">
    {children}
  </div>
);

export default ControlPanel;

import * as React from 'react';
import './index.scss';

type Props = {
  children: React.ReactNode
}

const ControlPanel = ({ children }: Props) => (
  <div className="controlPanel">
    {children}
  </div>
);

export default ControlPanel;

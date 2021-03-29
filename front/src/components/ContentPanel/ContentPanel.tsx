import * as React from 'react';
import './index.scss';

type Props = {
  children: React.ReactNode
}

const ContentPanel = ({ children }: Props) => (
  <div className="contentPanel">
    {children}
  </div>
);

export default ContentPanel;

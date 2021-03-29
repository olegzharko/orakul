import React from 'react';
import './index.scss';

type Props = {
  title: string;
  children: React.ReactNode;
}

const SectionWithTitle = ({ title, children }: Props) => (
  <div className="section-with-title">
    <div className="section-with-title__header">
      <h2>{title}</h2>
    </div>
    <div className="section-with-title__body">
      {children}
    </div>
  </div>
);

export default SectionWithTitle;
